<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Session::has('user_type')) {

            // $settings = Utility::settings();
            $Settings = Setting::pluck('value', 'name');

            return view('setting.index',compact('Settings'));
        } else {
            return redirect()->route('login');
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }

    public function SaveEmailSetting(Request $request)
    {
        $request->validate([
            'mail_mailer' => 'required|string|max:255',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|string|max:255',
            'mail_username' => 'required|string|max:255',
            'mail_password' => 'required|string|max:255',
            // 'mail_encryption' => 'required|string|max:255',
            'mail_from_address' => 'required|string|max:255',
            'mail_from_name' => 'required|string|max:255',
        ]);

        $settings = $request->all();
        unset($settings['_token']);
        foreach ($settings as $key => $data) {
            if (!empty($data)) {
                Setting::updateOrCreate(
                    ['name' => $key, 'created_by' => Session()->get('user_id')],
                    ['value' => $data]
                );
            }
        }
        // Set session variable to indicate email setting tab
        session()->flash('active_tab', 'email_setting');

        return redirect()->back()->with('success', __('Save Email Setting successfully.'));
    }

    public function ThemeSetting(Request $request)
    {
        $id = Session::get('user_id');
        $user = User::where('id', $id)->first();
        session()->forget('crm_theme_setting');
        if ($user->theme_setting == 'dark') {
            Session()->put('crm_theme_setting', 'light');
            $user->theme_setting = 'light';
            $user->save();
        } elseif ($user->theme_setting	== 'light') {
            Session()->put('crm_theme_setting', 'dark');
            $user->theme_setting = 'dark';
            $user->save();
        }
        return response()->json(['status' => true, 'theme' => $user->theme_setting]);
    }

    public function PaymentSetting(Request $request) {
        $request->validate([
            'stripe_currency' => 'required',
            'stripe_key' => 'required',
            'stripe_secret_key' => 'required',
        ]);

        $settings = $request->all();
        unset($settings['_token']);
        foreach ($settings as $key => $data) {
            if (!empty($data)) {
                Setting::updateOrCreate(
                    ['name' => $key, 'created_by' => Session()->get('user_id')],
                    ['value' => $data]
                );
            }
        }
        // Set session variable to indicate payment setting tab
        session()->flash('active_tab', 'payment_setting');
        return redirect()->back()->with('success', __('Save Payment Setting successfully.'));
    }
}
