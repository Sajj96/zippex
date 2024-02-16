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

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function cartItems()
    {
        $this->belongsToMany(Product::class, 'carts')
                ->withPivot(['id', 'user_id', 'product_id', 'quantity', 'status', 'created_at']);
    }

    public function orders()
    {
        $this->hasMany(Order::class);
    }

    public function getRoleNamesAttribute(){
        if ($this->getRoleNames()->count() > 0) {
            $roles = $this->getRoleNames()->all();
            return implode(',', $roles);
        }
        return "";
    }
    
    public function getReferralsAndDownlines($id, $level, $selectColumns = []) {
        $referralTable = 't' . $level;
        $referralModel = 'User';
    
        $referrals = $referralModel::select($selectColumns ?: ["$referralTable.*"])
            ->from("users as t1")
            ->leftJoin("users as $referralTable", "$referralTable.referrer_id", '=', "t1.id")
            ->where("t1.id", $id);
    
        if ($level > 1) {
            $referrals->leftJoin("users as t2", "t2.referrer_id", '=', "$referralTable.id")
                ->where("$referralTable.active", User::ACTIVE);
        }
    
        $referrals = $referrals->get();
    
        $downlines = $referralModel::select($selectColumns ?: ["$referralTable.id", "$referralTable.username", "$referralTable.phone", "$referralTable.active"])
            ->from("users as t1")
            ->leftJoin("users as $referralTable", "$referralTable.referrer_id", '=', "t1.id")
            ->where("t1.id", $id)
            ->where("$referralTable.id", '<>', '')
            ->get();
    
        return [
            'referrals' => $referrals,
            'downlines' => $downlines,
        ];
    }
    
}
