<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function withdraw(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'amount'  => 'required|numeric'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }

        try {

            $user = User::find($request->user_id);
            if(!$user){
                return response()->json(['error' => 'User not found']);
            }

            $balance = Transaction::getUserBalance($user->id);

            if($request->amount > $balance) {
                return redirect()->back()->with('error','You don\'t have enough balance to withdraw '. $request->amount);
            } else {
                $transaction = new Transaction;
                $transaction->balance = $request->balance;
                $transaction->user_id = $user->id;
                $transaction->amount = $request->amount;
                $transaction->amount_deposit = $request->deposit;
                $transaction->fee = $request->fee;
                $transaction->status = Transaction::TRANSACTION_PENDING;
    
                if($transaction->save()) {
                    return redirect()->route('withdraw')->with('success','You have successfully withdrawn '.$request->amount.'. Please wait for confirmation!.');
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('withdraw')->with('error','Something went wrong while withdrawing!');
        }
    }
}
