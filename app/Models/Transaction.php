<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    const TRANSACTION_PENDING = 0;
    const TRANSACTION_SUCCESS = 1;
    const TRANSACTION_CANCELLED = 2;

    const REGISTRATION_FEE = 15000;

    const TYPE_WITHDRAW = "Withdraw";
    const TYPE_PAY_FOR_DOWNLINE = "pay_for_downline";

    /**
     * Define relationships.
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * Get the user associated with the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the total earnings for a user.
     *
     * @return float
     */
    public static function getUserTotalEarnings($id)
    {
        $rate1 = User::LEVEL_1_EARNING;
        $rate2 = User::LEVEL_2_EARNING;
        $rate3 = User::LEVEL_3_EARNING;

        $user = User::find($id);
        $levelOne = $user->getLevelData($user->id, 1, User::LEVEL_1_EARNING)['activeReferrals'];
        $levelTwo = $user->getLevelData($user->id, 2, User::LEVEL_2_EARNING)['activeReferrals'];
        $levelThree = $user->getLevelData($user->id, 3, User::LEVEL_3_EARNING)['activeReferrals'];

        $levelOneEarnings = $levelOne * $rate1;
        $levelTwoEarnings = $levelTwo * $rate2;
        $levelThreeEarnings = $levelThree * $rate3;

        $totalEarnings = $levelOneEarnings + $levelTwoEarnings + $levelThreeEarnings;

        return $totalEarnings;
    }

    /**
     * Get user levels.
     *
     * @param int $id
     * @return array
     */
    private static function getUserLevels($id)
    {
        $levels = [];

        for ($i = 1; $i <= 3; $i++) {
            $levels[$i] = self::getUserLevel($id, $i);
        }

        return $levels;
    }

    /**
     * Get user referrals for a specific level.
     *
     * @param int $id
     * @param int $level
     * @return \Illuminate\Support\Collection
     */
    private static function getUserLevel($id, $level)
    {
        $downline = $level - 1;
        return User::leftJoin("users as t{$level}", "t{$level}.referrer_id", '=', "t{$downline}.id")
            ->where("t1.id", $id)
            ->where("t{$level}.status", User::ACTIVE)
            ->get();
    }

    /**
     * Get user balance.
     *
     * @return float
     */
    public static function getUserBalance($id)
    {
        $totalEarnings = self::getProfit($id);
        $withdrawn = self::getWithdrawals($id);

        $withdrawnAmount = $withdrawn ?? 0;

        return $totalEarnings - $withdrawnAmount;
    }

    /**
     * Get user withdrawn amount.
     *
     * @return float
     */
    public function getUserWithdrawnAmount($id)
    {
        $withdrawn = $this->where('transaction_type', self::TYPE_WITHDRAW)
            ->where('user_id', $id)
            ->sum('amount');

        return $withdrawn ?? 0;
    }

    public function getSystemEarnings()
    {
        $earning = DB::table('transactions')
                        ->where('currency', 'TZS')
                        ->sum('fee');

        $earning_amount = $earning ?? 0;
        return $earning_amount;
    }

    /**
     * Get user system earnings.
     *
     * @return float
     */
    public function getWithdrawRequests()
    {
        $withdraw_request = DB::table('transactions')
                                ->join('users','transactions.user_id','=','users.id')
                                ->select('transactions.*','users.username','users.name')
                                ->where('status',self::TRANSACTION_PENDING)
                                ->get();
                                
        $numRequest = count($withdraw_request) ?? 0;
        return $numRequest;
    }

    /**
     * Get profit.
     *
     * @return float
     */
    public static function getProfit($id)
    {
        $totalBalance = self::getUserTotalEarnings($id);

        $profit_amount = $totalBalance;
        return $profit_amount;
    }

    public static function getWithdrawals($id) 
    {
        $withdrawn = self::getUserWithdrawnAmount($id);

        $withdrawn_amount = $withdrawn;
        return $withdrawn_amount;
    }

    public function getUserNameAttribute()
    {
        if($this->user){
            return $this->user->name;
        }
        return "Unknown";
    }
}
