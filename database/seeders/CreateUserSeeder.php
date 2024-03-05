<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrPermissions = [
            [
                'name' => 'show dashboard',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            [
                'name' => 'manage user',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'create user',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'edit user',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'delete user',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'manage role',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'create role',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'edit role',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'delete role',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]

        ];

        Permission::insert($arrPermissions);

        $superAdminRole        = Role::create(
            [
                'name' => 'super admin',
                'created_by' => 0,
            ]
        );

        $superAdminPermissions = [
            ['name' => 'show dashboard'],
            ['name' => 'manage user'],
            ['name' => 'create user'],
            ['name' => 'edit user'],
            ['name' => 'delete user'],
        ];

        $superAdminRole->givePermissionTo($superAdminPermissions);

        $superAdmin = User::create(
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('1234'),
                'email_verified_at' => date("H:i:s"),
                'type' => 'super admin',
                'lang' => 'en',
                'avatar' => '',
                'created_by' => 0,
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // company
        $companyRole        = Role::create(
            [
                'name' => 'company',
                'created_by' => $superAdmin->id,
            ]
        );
        $companyPermissions = [
            ["name" => "manage user"],
            ["name" => "create user"],
            ["name" => "edit user"],
            ["name" => "delete user"],
            // ["name" => "change password account"],
            ["name" => "manage role"],
            ["name" => "create role"],
            ["name" => "delete role"],
            ["name" => "edit role"],
            // ["name" => "manage company setting"],
        ];

        $companyRole->givePermissionTo($companyPermissions);

        $company = User::create(
            [
                'name' => 'company',
                'email' => 'company@example.com',
                'password' => Hash::make('1234'),
                'type' => 'company',
                'lang' => 'en',
                'avatar' => '',
                'plan' => 1,
                'email_verified_at' => date("Y-m-d H:i:s"),
                'created_by' => $superAdmin->id,
            ]
        );
        $company->assignPlan(1);

        $company->assignRole($companyRole);
    }
}
