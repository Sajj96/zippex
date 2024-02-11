<?php

namespace Database\Seeders;

use App\Models\PermissionSet;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionsList = PermissionSet::permissions();
        foreach ($permissionsList as $key=>$value) {
            Permission::firstOrCreate(['name' => $value]);
        }

        //Default Role
        //Admin
        $admin = Role::firstOrCreate(['name' => User::ROLE_SUPER_ADMIN]);
        $admin->syncPermissions(Permission::all());
    }
}
