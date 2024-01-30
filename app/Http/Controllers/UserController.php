<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(UsersDataTable $datatable)
    {
        return $datatable->render('pages.users.index');
    }

    public function showLevelOne()
    {
        $id = Auth::user()->id;
        $user = new User;
        $active_referrals = $user->getLevelOneActiveReferrals($id);

        $active_referrals = count($active_referrals) ?? 0;

        $transaction = new Transaction;
        $rate = $transaction->getExchangeRate($id,5000,'TZS');

        $currency = $rate['currency'];
        $amount = $rate['amount'];
        

        $downlines = $user->getLevelOneDownlines($id);
        $level_two = $this->showLevelTwo();
        $level_three = $this->showLevelThree();

        return view('pages.team.index', compact('downlines','active_referrals','level_two', 'level_three', 'amount','currency'));
    }

    /**
     * Show the Level 2 page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLevelTwo()
    {
        $id = Auth::user()->id;
        $user = new User;
        $active_referrals = $user->getLevelTwoActiveReferrals($id);

        $active_referrals = count($active_referrals) ?? 0;

        $transaction = new Transaction;
        $rate = $transaction->getExchangeRate($id,3000,'TZS');

        $currency = $rate['currency'];
        $amount = $rate['amount'];
        
        $downlines = $user->getLevelTwoDownlines($id);
 
        return array(
            'downlines' => $downlines, 
            'active_referrals' => $active_referrals,
            'amount' => $amount
        );
    }

    /**
     * Show the Level 3 page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLevelThree()
    {
        $id = Auth::user()->id;
        $user = new User;
        $active_referrals = $user->getLevelThreeActiveReferrals($id);

        $active_referrals = count($active_referrals) ?? 0;

        $transaction = new Transaction;
        $rate = $transaction->getExchangeRate($id,2000,'TZS');

        $currency = $rate['currency'];
        $amount = $rate['amount'];

        $downlines = $user->getLevelThreeDownlines($id);

        return array(
            'downlines' => $downlines, 
            'active_referrals' => $active_referrals,
            'amount' => $amount
        );
    }
}
