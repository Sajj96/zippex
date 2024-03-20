<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Revenue extends Model
{
    use HasFactory;

    public const TYPE_COMMISSION = "Commission";
    public const STATUS_PENDING = 0;
    public const STATUS_PAID = 1;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'status'
    ];

    public static function referralCommission()
    {
        $users = User::select('*', DB::raw('COUNT(referrer_id) as count'))
                    ->whereBetween('created_at', 
                        [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                    )
                    ->where('status', User::ACTIVE)
                    ->whereNotNull('referrer_id')
                    ->groupBy('referrer_id')
                    ->orderBy(DB::raw('COUNT(referrer_id)'), 'DESC')
                    ->get();

        foreach($users as $user) {
            if($user->count >= 10) {
                self::create([
                    'user_id' => $user->id,
                    'amount' => $user->packageCommission * 2,
                    'type' => self::TYPE_COMMISSION,
                    'status' => self::STATUS_PAID
                ]);
            }
        }
    }

    public static function transactionCommission()
    {
        $transactions = Transaction::select('*', DB::raw('COUNT(*) as count'))
                    ->whereBetween('created_at', 
                        [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                    )
                    ->where('status', Transaction::TRANSACTION_SUCCESS)
                    ->orderBy('count', 'DESC')
                    ->get();

        foreach($transactions as $transaction) {
            $user = User::find($transaction->user_id);
            if($user && $transaction->count >= 10) {
                self::create([
                    'user_id' => $user->id,
                    'amount' => $user->packageCommission * 2,
                    'type' => self::TYPE_COMMISSION,
                    'status' => self::STATUS_PAID
                ]);
            }
        }
    }
}
