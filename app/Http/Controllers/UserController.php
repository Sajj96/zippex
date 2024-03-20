<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
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

        $levelOne = $user->getLevelData($user->id, 1, User::LEVEL_1_EARNING);
        $levelTwo = $user->getLevelData($user->id, 2, User::LEVEL_2_EARNING);
        $levelThree = $user->getLevelData($user->id, 3, User::LEVEL_3_EARNING);
        $orders = $user->orders;
        $profit = Transaction::getProfit($user->id);
        $user_address = $user->addresses()->latest()->take(1)->first();

        return view('pages.users.view', [
            'user' => $user,
            'orders' => $orders,
            'profit' => $profit,
            'user_address' => $user_address,
            'levelOne' => $levelOne,
            'levelTwo' => $levelTwo,
            'levelThree' => $levelThree
        ]);
    }

    public function add(Request $request)
    {
        if($request->method() == "GET") {
            $roles = Role::all();
            return view('pages.users.add', [ 'roles' => $roles ]);
        }

        try {
            $this->validate($request, [
                'name'     => 'required|string',
                'username' => 'required|string|unique:users',
                'phone'    => 'required|string|min:10|unique:users',
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
                return redirect('/users/platform-users')->with(['success' => 'User created successfully!']);
            }
        } catch (\Exception $th) {
            return back()->withError($th->getMessage());
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
            $user->assignRole(implode(',', $request->roles));
            $user->update();

            return redirect('/users/platform-users')->withSuccess('User updated successfully');
            
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
                return redirect()->route('user.platform')->withSuccess('User deleted successfully!');
            }
        } catch (\Exception $th) {
            return back()->withErrors('User was not deleted');
        }
    }

    public function activate(Request $request)
    {
        try {
            $user = User::where('id', $request->id)->first();
            $user->status = User::ACTIVE;
            $user->created_at = Carbon::now();
            if ($user->save()) {
                return redirect()->route('user')->with('success', 'User activated successfully!');
            }
        } catch (\Exception $e) {
            return redirect()->route('user')->with('error', $e->getMessage());
        }
    }

    public function deactivate(Request $request)
    {
        try {
            $user = User::where('id', $request->id)->first();
            $user->status = User::INACTIVE;
            if ($user->save()) {
                return redirect()->route('user.show', $request->id)->with('success', 'User deactivated successfully!');
            }
        } catch (\Exception $th) {
            return redirect()->route('user.show', $request->id)->with('error', 'User was not deactivated');
        }
    }

}
