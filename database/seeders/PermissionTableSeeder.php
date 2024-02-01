<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artisan::call('cache:forget spatie.permission.cache');
        Artisan::call('cache:clear');

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
                'name' => 'manage user profile',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'manage reset password',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'manage user login',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'manage user logs history',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'manage setting',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'manage setting logo',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'manage setting theme',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'manage setting storage',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'manage plan',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'create plan',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'edit plan',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'delete plan',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'orders plan',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'manage email template',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'manage language',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'manage user chat',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'manage roles',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'create roles',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'edit roles',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'delete roles',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'purchase plan',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'subscribe plan',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'manage leads',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'create leads',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'edit leads',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'delete leads',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        Permission::insert($arrPermissions);

        // Super Admin
        $admin = User::where('type','super admin')->first();
        if(empty($admin))
        {
            $admin = new User();
            $admin->name = 'Super Admin';
            $admin->email = 'superadmin@example.com';
            $admin->password = Hash::make('1234');
            $admin->email_verified_at = date('Y-m-d H:i:s');
            $admin->type = 'super admin';
            $admin->avatar = 'uploads/users-avatar/avatar.png';
            $admin->theme_setting = 0;
            $admin->lang = 'en';
            $admin->created_by = 0;
            $admin->save();

            $role = Role::where('name','super admin')->where('guard_name','web')->exists();
            if(!$role)
            {
                $superAdminRole        = Role::create(
                    [
                        'name' => 'super admin',
                        'created_by' => 0,
                    ]
                );
            }
            $role_r = Role::findByName('super admin');
            $admin->assignRole($role_r);
        }
        $role = Role::where('name','company')->where('guard_name','web')->exists();
        if(!$role)
        {
            $company_role        = Role::create(
                [
                    'name' => 'company',
                    'created_by' => $admin->id,
                ]
            );
        }

        $admin_permission = [
            'manage user',
            'create user',
            'edit user',
            'delete user',
            'manage user profile',
            'manage reset password',
            'manage user login',
            'manage user logs history',
            'manage setting',
            'manage setting logo',
            'manage setting theme',
            'manage setting storage',
            'manage plan',
            'create plan',
            'edit plan',
            'delete plan',
            'orders plan',
            'manage email template',
            'manage language',
        ];

        $compnay_permission = [
            'manage user',
            'create user',
            'edit user',
            'delete user',
            'manage user profile',
            'user chat manage',
            'manage reset password',
            'manage user login',
            'manage roles',
            'create roles',
            'edit roles',
            'delete roles',
            'manage plan',
            'purchase plan',
            'subscribe plan',
            'orders plan',
            'manage setting',
            'manage setting logo',
            'manage setting theme',
            'manage leads',
            'edit leads',
            'create leads',
            'delete leads',
        ];


        $superAdminRole  = Role::where('name','super admin')->first();
        foreach ($admin_permission  as $key => $value)
        {
            $permission = Permission::where('name',$value)->first();
            if(empty($permission))
            {
                $permission = Permission::create(
                    [
                        'name' => $value,
                        'guard_name' => 'web',
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s')
                    ]
                );
            }
            $superAdminRole->givePermissionTo($permission);
        }

        $company_role = Role::where('name','company')->first();
        foreach ($compnay_permission as $key => $value)
        {
            $permission = Permission::where('name',$value)->first();
            if(empty($permission))
            {
                $permission = Permission::create(
                    [
                        'name' => $value,
                        'guard_name' => 'web',
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s')
                    ]
                );
            }
            $company_role->givePermissionTo($permission);
        }

        if($admin)
        {
            $admin->assignRole($superAdminRole);

        }
        // Company
        $user = User::where('type','company')->first();
        if(empty($user))
        {
            $company = new User();
            $company->name = 'Rajodiya infotech';
            $company->email = 'company@example.com';
            $company->password = Hash::make('1234');
            $company->email_verified_at = date('Y-m-d H:i:s');
            $company->type = 'company';
            $company->avatar = 'uploads/users-avatar/avatar.png';
            $company->theme_setting = 0;
            $company->lang = 'en';
            $company->created_by = $admin->id;
            $company->save();


            User::CompanySetting($company->id);
        }
        $company = User::where('type','company')->first();
        if($company)
        {
            $company->assignRole($company_role);
        }
    }
}
