<?php

namespace App\Http\Controllers;

use App\DataTables\TransactionsDataTable;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(TransactionsDataTable $datatable)
    {
        $withdraw_requests = Transaction::whereStatus(Transaction::TRANSACTION_PENDING)->get();
        return $datatable->render('pages.transactions.index', [
            'withdraw_requests' =>  $withdraw_requests
        ]);
    }

    public function acceptWithdraw(Request $request)
    {
        try {
            $withdraw = Transaction::find($request->withdraw_id);
            $withdraw->status = Transaction::TRANSACTION_SUCCESS;
            if($withdraw->save()){
                return redirect()->route('transaction')->with('success','Withdraw request accepted!');
            }
        } catch (\Exception $e) {
            $withdraw = Transaction::find($request->id);
            return redirect()->route('transaction')->with('error',$e->getMessage());
        }
    }

    public function declineWithdraw(Request $request)
    {
        try {
            $withdraw = Transaction::find($request->id);
            $withdraw->status = Transaction::TRANSACTION_CANCELLED;
            if($withdraw->save()){
                return redirect()->route('transaction')->with('success','Withdraw request declined!');
            }
        } catch (\Exception $e) {
            return redirect()->route('transaction')->with('error','Something went wrong while cancelling withdraw request!');
        }
    }
}
