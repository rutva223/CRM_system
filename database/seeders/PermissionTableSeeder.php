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
            'user manage',
            'user create',
            'user edit',
            'user delete',
            'user profile manage',
            'user reset password',
            'user login manage',
            'user import',
            'user logs history',
            'setting manage',
            'setting logo manage',
            'setting theme manage',
            'setting storage manage',
            'plan manage',
            'plan create',
            'plan edit',
            'plan delete',
            'plan orders',
            'email template manage',
            'language manage',
        ];

            $compnay_permission = [
                'user manage',
                'user create',
                'user edit',
                'user delete',
                'user profile manage',
                'user chat manage',
                'user reset password',
                'user login manage',
                'user import',
                'roles manage',
                'roles create',
                'roles edit',
                'roles delete',
                'plan manage',
                'plan purchase',
                'plan subscribe',
                'plan orders',
                'setting manage',
                'setting logo manage',
                'setting theme manage',
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
