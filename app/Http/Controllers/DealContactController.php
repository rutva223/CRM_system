<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\DealContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->can('create dealcontact'))
        {
            $id =  Session()->get('user_id');
            $contact = Contact::join('users', 'contacts.user_id', '=', 'users.id')
                        ->where('contacts.created_by', $id)
                        ->pluck('users.name', 'contacts.id');

            return view('deal_contact.create',compact('contact'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(DealContact $dealContact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DealContact $dealContact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DealContact $dealContact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DealContact $dealContact)
    {
        //
    }
}
