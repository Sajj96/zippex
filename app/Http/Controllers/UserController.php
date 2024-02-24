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
        $this->showTeamLevels();
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

    public function showTeamLevels()
    {
        $user = Auth::user();
    
        $levelOne = $user->getLevelData($user->id, 1, 5000);
        $levelTwo = $user->getLevelData($user->id, 2, 3000);
        $levelThree = $user->getLevelData($user->id, 3, 2000);
    
        return view('pages.team.index', compact('levelOne', 'levelTwo', 'levelThree'));
    }
}
