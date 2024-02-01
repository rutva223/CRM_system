<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if('manage leads'){
            $leads = Lead::leftjoin('users', 'users.id', '=', 'leads.user_id')
                ->select('leads.*', 'users.name')
                ->orderBy('id', 'desc')
                ->get();

            return view('lead.index',compact('leads'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->can('create leads')) {
            $user = User::where('type','!=','company')->where('type','!=','super admin')->pluck('name','id');
            return view('lead.create', compact('user'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('create leads'))
        {
            $validatorArray = [
                'title' => 'required|max:120',
                'user_id' => 'required',
            ];
            $validator = Validator::make(
                $request->all(), $validatorArray
            );
            if($validator->fails())
            {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $leads = new Lead();
            $leads->title = $request->title;
            $leads->user_id = $request->user_id;
            $leads->description = $request->description;
            $leads->save();
            return redirect()->back()->with('success', __('Lead create successfully!'));

        }else{
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        if (Auth::user()->can('edit leads'))
        {
            $user = User::where('type','!=','company')->where('type','!=','super admin')->pluck('name','id');

            return view('lead.edit',compact('lead','user'));

        }else{
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('edit leads'))
        {
            $validatorArray = [
                'title' => 'required|max:120',
                'user_id' => 'required',
            ];
            $validator = Validator::make(
                $request->all(), $validatorArray
            );
            if($validator->fails())
            {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $leads              = Lead::find($id);
            $leads->title       = $request->title;
            $leads->user_id     = $request->user_id;
            $leads->description = $request->description;
            $leads->save();
            return redirect()->back()->with('success', __('Lead create successfully!'));

        }else{
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        dd($id);
        if(Auth::user()->can('delete lead'))
        {
            // $lead = Lead::find($lead)->delete();
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
