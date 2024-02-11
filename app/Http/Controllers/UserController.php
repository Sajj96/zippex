<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(UsersDataTable $datatable)
    {
        return $datatable->render('pages.users.index');
    }

    public function getPlatformUsers()
    {
        $users = User::where('user_type', User::ADMIN)->get();
        return view('pages.users.platform-users', [ 'users' => $users ]);
    }

    public function show($id)
    {
        if (empty($id)) {
            return redirect('/users')->withWarning("User was not selected");
        }

        $user = User::find($id);
        if (!$user) {
            return redirect('/users')->withError('User not found');
        }

        return view('pages.users.view', [
            'user' => $user
        ]);
    }

    public function add(Request $request)
    {
        if($request->method() == "GET") {
            $roles = Role::all();
            return view('pages.users.add', [ 'roles' => $roles ]);
        }

        try {
            $request->validate($request, [
                'name'     => 'required|string',
                'username' => 'required|string|unique:users',
                'phone'    => 'required|string|min:11|unique:users',
                'email'    => 'required|email|unique:users',
                'password' => 'required|string|confirmed|min:6',
                'roles'    => 'required'
            ]);

            $user = User::create([
                'name'     => $request->name,
                'username' => $request->username,
                'phone'    => $request->phone,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => User::ADMIN,
                'status'    => User::ACTIVE
            ]);

            if($user) {
                $user->assignRole(implode(',', $request->roles));
                return redirect('/users')->with(['success' => 'User created successfully!']);
            }
        } catch (\Exception $th) {
            return back()->withError('Failed to create the user');
        }
    }

    public function edit($id, Request $request)
    {
        if (empty($id) && $request->has('id')) {
            $id = $request->id;
        }

        $user = User::find($id);
        if (!$user) {
            return redirect('/users')->withError('User not found');
        }

        if ($request->method() == 'GET') {
            $roles = Role::all();
            $userRoles = Role::whereIn('name',$user->getRoleNames())->pluck('name')->toArray();
            return view('pages.users.edit', [
                'user' => $user,
                'roles' => $roles,
                'userRoles' => $userRoles
            ]);
        }

        try {
            $user->name  = $request->name;
            $user->username   = $request->username;
            $user->phone       = $request->phone;
            $user->email       = $request->email;
            if($request->has('password')) {
                $user->password     = Hash::make($request->password);
            }
            $user->user_type    = $request->user_type;
            $user->update();

            return redirect('/users')->withSuccess('User updated successfully');
            
        } catch (\Exception $exception) {
            return back()->withError('Could not Update the selected user');
        }
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return back()->withError('User not found');
        }

        if ($request->method() == 'GET') {
            return view('pages.users.change_password');
        }

        try {
            $this->validate($request, [
                'password' => 'required|confirmed',
            ]);

            $user->password = Hash::make($request->password);
            $user->update();

            return redirect('/home')->withSuccess('Password updated successfully');
        } catch (\Exception $exception) {
            return back()->withError('Password change failed');
        }
    }

    public function delete(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            if($user->delete()) {
                return redirect()->route('user')->withSuccess('User deleted successfully!');
            }
        } catch (\Exception $th) {
            return back()->withErrors('User was not deleted');
        }
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
