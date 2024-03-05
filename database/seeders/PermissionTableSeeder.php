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
            // $admin->avatar = 'uploads/users-avatar/avatar.png';
            $admin->theme_setting = 'light';
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
            'manage coupons',
            'edit coupons',
            'create coupons',
            'delete coupons',
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
            'report deal',
            'manage deal',
            'create deal',
            'edit deal',
            'delete deal',
            'show deal',
            'move deal',
            'import deal',
            'create deal task',
            'edit deal task',
            'delete deal task',
            'show deal task',
            'create deal call',
            'edit deal call',
            'delete deal call',
            'create deal meeting',
            'edit deal meeting',
            'delete deal meeting',
            'deal email create',
            'manage pipeline',
            'create pipeline',
            'edit pipeline',
            'delete pipeline',
            'manage dealstages',
            'create dealstages',
            'edit dealstages',
            'delete dealstages',
            'manage labels',
            'create labels',
            'edit labels',
            'delete labels',
            'manage source',
            'create source',
            'edit source',
            'delete source',
            'manage contacts',
            'edit contacts',
            'create contacts',
            'delete contacts',
            'manage dealtype',
            'edit dealtype',
            'create dealtype',
            'delete dealtype',
            'manage dealcontact',
            'edit dealcontact',
            'create dealcontact',
            'delete dealcontact',

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
            $company->name = 'Company';
            $company->email = 'company@example.com';
            $company->password = Hash::make('1234');
            $company->email_verified_at = date('Y-m-d H:i:s');
            $company->type = 'company';
            // $company->avatar = 'uploads/users-avatar/avatar.png';
            $company->theme_setting = 'light';
            $company->plan = 1;
            $company->plan_expire_date = 2030-02-29;
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
