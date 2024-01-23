<?php

namespace App\Http\Controllers;

use App\Models\Setting;
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
        if (Session::has('a_type')) {

            // $settings = Utility::settings();
            $emailSettings = Setting::get();

            return view('setting.index',compact('emailSettings'));
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
        // dd($request->all());
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
                    ['name' => $key, 'created_by' => Session()->get('admin_id')],
                    ['value' => $data]
                );
            }
        }
        return redirect()->back()->with('success', __('Save Email Setting successfully.'));
    }
}
