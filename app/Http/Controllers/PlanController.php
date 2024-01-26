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
        if((Auth::user()->can('plan manage')) && (Session::has('user_type') == 'super admin'))
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
        if (Auth::user()->can('plan create'))
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
        if(Auth::user()->can('plan create'))
        {
            $validatorArray = [
                'name' => 'required|max:120',
                'price' => 'required',
                'max_user' => 'required',
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
        if (Auth::user()->can('plan edit'))
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
        if(Auth::user()->can('plan edit'))
        {
            $validatorArray = [
                'name' => 'required|max:120',
                'price' => 'required',
                'max_user' => 'required',
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

    public function PlanSubscripe($id)
    {
        if(Session::has('user_type') == 'super admin')
        {
            if($id)
            {
                try {
                    $id       = Crypt::decrypt($id);
                } catch (\Throwable $th) {
                    return redirect()->back()->with('error', __('Plan Not Found.'));
                }

            }
            $plan = Plan::find($id);
            $duration = $plan->duration;
            $user = User::find(Auth::user()->id);
            if(!empty($duration))
            {
                if($duration == 'Monthly')
                {
                    $user->plan_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
                }
                elseif($duration == 'Yearly')
                {
                    $user->plan_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
                }
                elseif($duration == 'Lifetime')
                {
                    $user->plan_expire_date = Carbon::now()->addYears(10)->isoFormat('YYYY-MM-DD');
                }
                else{
                    $user->plan_expire_date = null;
                }
            }else
            {
                $user->plan_expire_date = null;
                // for days
                // $this->plan_expire_date = Carbon::now()->addDays($duration)->isoFormat('YYYY-MM-DD');
            }
            $user->plan = $plan->id;
            $user->save();
            return redirect()->back()->with('success', __('Plan Subscribe successfully!'));

        }else  {
            return redirect()->back()->with('error', __('Permission denied.'));

        }
    }
}
