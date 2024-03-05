<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if((Auth::user()->can('manage plan')))
        {
            $plans = Plan::get();
            return view('plan.index',compact('plans'));

        }   else  {
            return redirect()->back()->with('error', __('Permission denied.'));

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->can('create plan'))
        {
            return view('plan.create');

        }else{
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('create plan'))
        {
            $validatorArray = [
                'name' => 'required|max:120',
                'price' => 'required',
                'max_user' => 'required',
                'max_customer' => 'required',
                'max_vendor' => 'required',
                'duration' => 'required',
                'description' => 'required',
            ];
            $validator = Validator::make(
                $request->all(), $validatorArray
            );
            if($validator->fails())
            {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $plan = new Plan();
            $plan->name = $request->name;
            $plan->price = $request->price;
            $plan->max_user = $request->max_user;
            $plan->max_customer = $request->max_customer;
            $plan->max_vendor = $request->max_vendor;
            $plan->duration = $request->duration;
            $plan->description = $request->description;
            $plan->save();
            return redirect()->back()->with('success', __('Plan create successfully!'));

        }else{
            return redirect()->back()->with('error', __('Permission denied.'));

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        if (Auth::user()->can('edit plan'))
        {
            return view('plan.edit',compact('plan'));

        }else{
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        if(Auth::user()->can('edit plan'))
        {
            $validatorArray = [
                'name' => 'required|max:120',
                'price' => 'required',
                'max_user' => 'required',
                'max_customer' => 'required',
                'max_vendor' => 'required',
                'duration' => 'required',
                'description' => 'required',
            ];
            $validator = Validator::make(
                $request->all(), $validatorArray
            );
            if($validator->fails())
            {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $plan->name = $request->name;
            $plan->price = $request->price;
            $plan->max_user = $request->max_user;
            $plan->max_customer = $request->max_customer;
            $plan->max_vendor = $request->max_vendor;
            $plan->duration = $request->duration;
            $plan->description = $request->description;
            $plan->save();
            return redirect()->back()->with('success', __('Plan updated successfully!'));
        }else{
            return redirect()->back()->with('error', __('Permission denied.'));

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        //
    }

    public function PlanSubscripe($id) {
        try{
            $plan_id = \Illuminate\Support\Facades\Crypt::decrypt($id);
            $plan    = Plan::find($plan_id);
            if($plan)
            {
                // $admin_payment_setting = Utility::payment_settings();
                return view('plan.payment', compact('plan'));
            }
            else
            {
                return redirect()->back()->with('error', __('Plan is deleted.'));
            }
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}
