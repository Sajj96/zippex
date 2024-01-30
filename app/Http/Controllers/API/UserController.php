<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() 
    {
        $users = User::where('deleted_at', NULL)->lazy();
        return response()->json([ 'users' => $users ]);
    }

    public function getUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone'     => 'required|string',
            'user_type' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }

        try {

            $user = User::wherePhone($request->phone)->where('user_type', $request->user_type)->where('deleted_at', NULL)->first();

            if(!$user){
                return response()->json(['error' => 'User not found']);
            }

            $transaction = new Transaction;
            $wallet = $transaction->getWallet($user->id);
            $commission = $transaction->getCommission($user->id);

            return response()->json([
                'user' => $user,
                'wallet_balance' => $wallet,
                'commission_balance' => $commission,
                'referrals' => count($user->referrals)  ?? '0'
            ], 200);

        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getProfile()
    {
        $user = auth('api')->user();
        return response()->json(['user'=>$user], 201);
    }
}
