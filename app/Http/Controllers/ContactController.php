<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Symfony\Component\Mime\Part\TextPart;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if('manage contacts') {
            $contacts = Contact::orderBy('id', 'desc')
                        ->get();

            return view('contact.index',compact('contacts'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if('create contacts') {

            return view('contact.create');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(Auth::user()->can('create contacts'))
        {
            $validatorArray = [
                'email' => 'required|email',
                'f_name' => 'required|max:120',
                'l_name' => 'required|max:120',
                'phone_no' => 'required|digits_between:10,12',
                'assistants_name' => 'required|max:120',
                'assistants_mail' => 'required|max:120',
                'assistants_phone' => 'required|digits_between:10,12',
                'department_name' => 'required|max:120',
                'dob' => 'required|max:120',
            ];
            $validator = Validator::make(
                $request->all(), $validatorArray
            );

            if($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $created_by =  Session()->get('user_id') ?? creatorId();
            $role = Role::where('name','client')->where('created_by',$created_by)->first();

            $user               = new User();
            $user->name         = $request->f_name.' '.$request->l_name;
            $user->email        = $request->email;
            $user->password     = Hash::make(123456);
            $user->lang         = 'en';
            $user->type         = $role->name;
            $user->created_by   = $created_by;
            $user->save();
            $user->assignRole($role);

            $contacts = new Contact();
            $contacts->user_id = $user->id;
            $contacts->f_name = $request->f_name;
            $contacts->l_name = $request->l_name;
            $contacts->email = $request->email;
            $contacts->phone_no = $request->phone_no;
            $contacts->assistants_name = $request->assistants_name;
            $contacts->assistants_mail = $request->assistants_mail;
            $contacts->assistants_phone = $request->assistants_phone;
            $contacts->department_name = $request->department_name;
            $contacts->dob = $request->dob;
            $contacts->social_media_profile = $request->social_media_profile ?? null;
            $contacts->notes = $request->notes ?? null;
            $contacts->send_mail = $request->send_mail ?? 'off';

            $contacts->billing_city = $request->billing_city ?? null;
            $contacts->billing_state = $request->billing_state ?? null;
            $contacts->billing_country = $request->billing_country ?? null;
            $contacts->billing_zip = $request->billing_zip ?? null;
            $contacts->shipping_city = $request->shipping_city ?? null;
            $contacts->shipping_state = $request->shipping_state ?? null;
            $contacts->shipping_country = $request->shipping_country ?? null;
            $contacts->shipping_zip = $request->shipping_zip ?? null;
            $contacts->created_by = $created_by;

            $contacts->save();

            try {
                if ($request->has('send_mail') && $request->input('send_mail') == 'on') {

                    $details = [
                        'title' => 'Success',
                    ];
                    $from_email = env('MAIL_FROM_ADDRESS');
                    $fromName = env('MAIL_USERNAME');
                    $to_client_email = $request->email;

                    Mail::send("email.contact_info", compact('contacts', 'details'), function ($message) use ($from_email, $to_client_email, $fromName) {
                        $message->to($to_client_email);
                        $message->from($from_email, $fromName)
                            ->subject('Contact Data - CRM Admin');
                    });

                    Log::info("Contact Data mail sent");
                }
            } catch (\Throwable $th) {
                Log::info("Contact Data not work ERROR cache: {$th->getMessage()}");
            }

            return redirect()->route('contacts.index')->with('success', __('contact create successfully!'));

        }else{
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if('edit contacts') {

            $contact = Contact::orderBy('id', 'desc')
                        ->find($id);

            return view('contact.edit',compact('contact'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        if(Auth::user()->can('create contacts'))
        {
            $validatorArray = [
                'email' => 'required|email',
                'f_name' => 'required|max:120',
                'l_name' => 'required|max:120',
                'phone_no' => 'required|digits_between:10,12',
                'assistants_name' => 'required|max:120',
                'assistants_mail' => 'required|max:120',
                'assistants_phone' => 'required|digits_between:10,12',
                'department_name' => 'required|max:120',
                'dob' => 'required|max:120',
            ];
            $validator = Validator::make(
                $request->all(), $validatorArray
            );
            if($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $contacts = Contact::findOrFail($id);
            $created_by =  Session()->get('user_id') ?? creatorId();
            $user = User::where('id',$contacts->user_id)->where('created_by',$created_by)->first();
            $user->name = $request->f_name.' '.$request->l_name;
            $user->email = $request->email;
            $user->save();
            $contacts->f_name = $request->f_name;
            $contacts->l_name = $request->l_name;
            $contacts->phone_no = $request->phone_no;
            $contacts->assistants_name = $request->assistants_name;
            $contacts->assistants_mail = $request->assistants_mail;
            $contacts->assistants_phone = $request->assistants_phone;
            $contacts->department_name = $request->department_name;
            $contacts->dob = $request->dob;
            $contacts->social_media_profile = $request->social_media_profile ?? null;
            $contacts->notes = $request->notes ?? null;
            $contacts->send_mail = $request->send_mail ?? 'off';

            $contacts->billing_city = $request->billing_city ?? null;
            $contacts->billing_state = $request->billing_state ?? null;
            $contacts->billing_country = $request->billing_country ?? null;
            $contacts->billing_zip = $request->billing_zip ?? null;
            $contacts->shipping_city = $request->shipping_city ?? null;
            $contacts->shipping_state = $request->shipping_state ?? null;
            $contacts->shipping_country = $request->shipping_country ?? null;
            $contacts->shipping_zip = $request->shipping_zip ?? null;

            $contacts->save();

            try {
                if ($request->has('send_mail') && $request->input('send_mail') == 'on') {
                    $user = User::where('id',$contacts->user_id)->first();

                    $details = [
                        'title' => 'Success',
                    ];
                    $from_email = env('MAIL_FROM_ADDRESS');
                    $fromName = env('MAIL_USERNAME');
                    $to_client_email = $user->email;

                    Mail::send("email.contact_info", compact('contacts', 'details'), function ($message) use ($from_email, $to_client_email, $fromName) {
                        $message->to($to_client_email);
                        $message->from($from_email, $fromName)
                            ->subject('Contact Data - CRM Admin');
                    });

                    Log::info("Contact Data mail sent");
                }
            } catch (\Throwable $th) {
                Log::info("Contact Data not work ERROR cache: {$th->getMessage()}");
            }

            return redirect()->route('contacts.index')->with('success', __('Contact Updated Successfully!'));

        }else{
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
