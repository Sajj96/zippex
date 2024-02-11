<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin = User::firstOrNew(['email'=>'admin@example.com']);
        $super_admin->name = 'Super Admin';
        $super_admin->username = 'Admin';
        $super_admin->phone = '0717000000';
        $super_admin->password = Hash::make('Admin123');
        $super_admin->country = 'tz';
        $super_admin->user_type = User::ADMIN;
        $super_admin->status = User::ACTIVE;
        $super_admin->save();

        $role = Role::create(["name" => "Super Admin"]);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $super_admin->assignRole([$role->id]);
    }
}
