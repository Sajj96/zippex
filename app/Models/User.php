<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    public const ADMIN = 0;
    public const CLIENT = 1;

    public const INACTIVE = 0;
    public const ACTIVE = 1;

    public const ROLE_SUPER_ADMIN = "Super Admin";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'referrer_id',
        'user_type',
        'country',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['referral_code'];

    /**
     * Get the user's referral code.
     *
     * @return string
     */
    public function getReferralCodeAttribute()
    {
        return $this->referral_code = str_replace(array('+255','255'),array('',''),$this->phone.$this->user_type);
    }

    /**
     * A user has a referrer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referrer()
    {
        return $this->belongsTo(self::class, 'referrer_id', 'id');
    }

    /**
     * A user has many referrals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrals()
    {
        return $this->hasMany(self::class, 'referrer_id', 'id');
    }

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function activeReferrals()
    {
        return self::where('referrer_id', Auth::user()->id)
                    ->where('active', self::ACTIVE)
                    ->get();
    }

    public function getAllUsers()
    {
        $users = self::count();
        return $users;
    }

    public function getAllActiveUsers()
    {
        $users = self::where('active',1)->count();
        return $users;
    }

    public function cart(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, Cart::class);
    }

    public function getRoleNamesAttribute(){
        if ($this->getRoleNames()->count() > 0) {
            $roles = $this->getRoleNames()->all();
            return implode(',', $roles);
        }
        return "";
    }
    
    public function getLevelOneActiveReferrals($id) {
        $referral = DB::table('users','t1')
                        ->leftJoin('users as t2', 't2.referrer_id','=','t1.id')
                        ->where(DB::raw('t1.id'), DB::raw($id))
                        ->where(DB::raw('t1.active'), DB::raw(self::ACTIVE))
                        ->where(DB::raw('t2.active'), DB::raw(self::ACTIVE))
                        ->get();

        return $referral;
    }

    public function getLevelOneDownlines($id) {
        $downlines = DB::table('users','t1')
                    ->leftJoin('users as t2', 't2.referrer_id','=','t1.id')
                    ->select(DB::raw('t2.id as id'),DB::raw('t2.username as username'),DB::raw('t2.phone as phone'),DB::raw('t2.active as active'))
                    ->where(DB::raw('t1.id'), DB::raw($id))
                    ->where(DB::raw('t2.id'), "<>","")
                    ->get();

        return $downlines;
    }

    public function getLevelTwoActiveReferrals($id) {
        $referral = DB::table('users','t1')
                        ->leftJoin('users as t2', 't2.referrer_id','=','t1.id')
                        ->leftJoin('users as t3', 't3.referrer_id','=','t2.id')
                        ->where(DB::raw('t1.id'), DB::raw($id))
                        ->where(DB::raw('t3.active'), DB::raw(User::ACTIVE))
                        ->get();

        return $referral;
    }

    public function getLevelTwoDownlines($id) {
        $downlines = DB::table('users','t1')
                        ->leftJoin('users as t2', 't2.referrer_id','=','t1.id')
                        ->leftJoin('users as t3', 't3.referrer_id','=','t2.id')
                        ->select(DB::raw('t3.id as id'),DB::raw('t3.username as username'),DB::raw('t3.phone as phone'),DB::raw('t3.active as active'))
                        ->where(DB::raw('t1.id'), DB::raw($id))
                        ->where(DB::raw('t3.id'), "<>","")
                        ->get();

        return $downlines;
    }

    public function getLevelThreeActiveReferrals($id) {
        $referral = DB::table('users','t1')
                        ->leftJoin('users as t2', 't2.referrer_id','=','t1.id')
                        ->leftJoin('users as t3', 't3.referrer_id','=','t2.id')
                        ->leftJoin('users as t4', 't4.referrer_id','=','t3.id')
                        ->where(DB::raw('t1.id'), DB::raw($id))
                        ->where(DB::raw('t4.active'), DB::raw(User::ACTIVE))
                        ->get();

        return $referral;
    }

    public function getLevelThreeDownlines($id) {
        $downlines = DB::table('users','t1')
                        ->leftJoin('users as t2', 't2.referrer_id','=','t1.id')
                        ->leftJoin('users as t3', 't3.referrer_id','=','t2.id')
                        ->leftJoin('users as t4', 't4.referrer_id','=','t3.id')
                        ->select(DB::raw('t4.id as id'),DB::raw('t4.username as username'),DB::raw('t4.phone as phone'),DB::raw('t4.active as active'))
                        ->where(DB::raw('t1.id'), DB::raw($id))
                        ->where(DB::raw('t4.id'), "<>","")
                        ->get();

        return $downlines;
    }
}
