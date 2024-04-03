<?php

use App\Models\Plan;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

if (!function_exists('creatorId')) {
    function creatorId()
    {
        if (Session::get('user_type') == 'super admin' || Session::get('user_type') == 'company') {
            return Session()->get('user_id');
        } else {
            return Auth::user()->created_by;
        }
    }
}

if (!function_exists('PlanCheck')) {
    function PlanCheck($id = null, $type = null)
    {
        if (!empty($id)) {
            $user = User::where('id', $id)->first();
            $plan = Plan::where('id', $user->plan)->first();
            $id = $user->id;
        } else {
            $user = Session()->get('user_id') ?? Auth::user();
            $id = $user->id;
        }

        if ($type == 'customer') {
            if ($plan->max_customer >= 0) {
                $cu_users = User::where('created_by', $id)->where('type', 'customer')->get();

                if ($cu_users->count() >= $plan->max_customer) {
                    return false;
                } else {
                    return true;
                }
            } elseif ($plan->max_customer < 0) {
                return true;
            }
        } elseif ($type == 'vendor') {
            if ($plan->max_vendor >= 0) {
                $users = User::where('created_by', $id)->where('type', 'vendor')->get();
                if ($users->count() >= $plan->max_vendor) {
                    return false;
                } else {
                    return true;
                }
            } elseif ($plan->max_vendor < 0) {
                return true;
            }
        } else {
            if ($plan->max_user >= 0) {
                $users = User::where('created_by', $id)->where('type', '!=', 'customer')->where('type', '!=', 'vendor')->get();
                if ($users->count() >= $plan->max_user) {
                    return false;
                } else {
                    return true;
                }
            } elseif ($plan->max_user < 0) {
                return true;
            }
        }
    }
}


function UploadImageFolder($folder_name, $file_name)
{
    $paths = public_path($folder_name);
    if (!is_dir($paths)) {
        mkdir($paths, 0755, true);
    }
    $filename = time() . '_' . $file_name->getClientOriginalName();
    $file_name->move($paths, $filename);
    return $filename;
}

if (!function_exists('admin_setting')) {
    function admin_setting($key)
    {
        if ($key) {
            $admin_settings = getAdminAllSetting();
            $setting = (array_key_exists($key, $admin_settings)) ? $admin_settings[$key] : null;
            return $setting;
        }
    }
}

if (!function_exists('getAdminAllSetting')) {
    function getAdminAllSetting()
    {
        // Laravel cache
        return Cache::rememberForever('admin_settings', function () {
            $super_admin = User::where('type', 'super admin')->first();
            $settings = [];
            if ($super_admin) {
                $settings = Setting::where('created_by', $super_admin->id)->pluck('value', 'name')->toArray();
            }

            return $settings;
        });
    }
}

if (!function_exists('getCompanyAllSetting')) {
    function getCompanyAllSetting($user_id = null)
    {
        if (!empty($user_id)) {
            $user = User::find($user_id);
        } else {
            $user =  auth()->user();
        }

        // // Check if the user is not 'company' or 'super admin' and find the creator
        if (!in_array($user->type, ['company', 'super admin'])) {
            $user = User::find($user->created_by);
        }

        if (!empty($user)) {
            $key = 'company_settings_'. $user->id;
            return Cache::rememberForever($key, function () use ($user) {
                $settings = [];
                $settings = Setting::where('created_by', $user->id)->pluck('value', 'name')->toArray();
                return $settings;
            });
        }

        return [];
    }
}

if (!function_exists('company_setting')) {
    function company_setting($key, $user_id = null, $workspace = null)
    {
        if ($key) {
            $company_settings = getCompanyAllSetting($user_id, $workspace);
            $setting = null;
            if (!empty($company_settings)) {
                $setting = (array_key_exists($key, $company_settings)) ? $company_settings[$key] : null;
            }
            return $setting;
        }
    }
}
if (!function_exists('upload_file')) {
    function upload_file($request, $key_name, $name, $path, $custom_validation = [])
    {
        try {
            $max_size = 2048; // Max size in kilobytes
            $mimes = ['jpeg', 'jpg', 'png', 'svg', 'zip', 'txt', 'gif', 'docx']; // Allowed mime types

            // Custom validation rules
            if (count($custom_validation) > 0) {
                $validation = $custom_validation;
            } else {
                $validation = [
                    'mimes:' . implode(',', $mimes),
                    'max:' . $max_size,
                ];
            }

            // Validate the uploaded file
            $validator = Validator::make($request->all(), [
                $key_name => $validation
            ]);

            if ($validator->fails()) {
                $res = [
                    'flag' => 0,
                    'msg' => $validator->messages()->first(),
                ];
                return $res;
            } else {
                // Get the uploaded file
                $file = $request->file($key_name);
                // Generate unique name for the file
                $filename = $name . '.' . $file->getClientOriginalExtension();

                // Move the file to the specified path
                $file->move(storage_path($path), $filename);

                $url = $path . '/' . $filename; // Assuming $path is relative to the public directory
                $res = [
                    'flag' => 1,
                    'msg'  => 'success',
                    'url'  => $url
                ];
                return $res;
            }
        } catch (\Exception $e) {
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }
}
if (!function_exists('delete_file')) {
    function delete_file($path)
    {
        return File::delete($path);
    }
}
if (!function_exists('get_file')) {
    function get_file($path)
    {
        return asset('storage/' . $path);
    }
}

if (!function_exists('get_size')) {
    function get_size($url)
    {
        $url = str_replace(' ', '%20', $url);
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);

        $data = curl_exec($ch);
        $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

        curl_close($ch);
        return $size;
    }
}
