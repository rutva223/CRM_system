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

    // public function PlanSubscripe($id)
    // {
    //     if(Auth::user()->can('subscribe plan'))
    //     {
    //         if($id)
    //         {
    //             try {
    //                 $id       = Crypt::decrypt($id);
    //             } catch (\Throwable $th) {
    //                 return redirect()->back()->with('error', __('Plan Not Found.'));
    //             }

    //         }
    //         $plan = Plan::find($id);
    //         $duration = $plan->duration;
    //         $user = User::find(Auth::user()->id);
    //         if(!empty($duration))
    //         {
    //             if($duration == 'Monthly')
    //             {
    //                 $user->plan_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
    //             }
    //             elseif($duration == 'Yearly')
    //             {
    //                 $user->plan_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
    //             }
    //             elseif($duration == 'Lifetime')
    //             {
    //                 $user->plan_expire_date = Carbon::now()->addYears(10)->isoFormat('YYYY-MM-DD');
    //             }
    //             else{
    //                 $user->plan_expire_date = null;
    //             }
    //         }else
    //         {
    //             $user->plan_expire_date = null;
    //             // for days
    //             // $this->plan_expire_date = Carbon::now()->addDays($duration)->isoFormat('YYYY-MM-DD');
    //         }
    //         $users = User::where('created_by',$user->id)->where('is_active',1)->get();
    //         $total_users =  $users->count();
    //         if($plan->max_user > 0)
    //         {
    //             if($total_users > $plan->max_user){
    //                     $count_user = $total_users - $plan->max_user;
    //                     $usersToDisable = User::orderBy('created_at', 'desc')->where('created_by',$user->id)->where('is_active',1)->take($count_user)->get();
    //                     foreach($usersToDisable as $item){
    //                         $item->is_active = 0;
    //                         $item->save();
    //                     }
    //             }else{
    //                 $count_user =  $plan->max_user - $total_users ;
    //                 $users = User::where('created_by',$user->id)->where('is_active',0)->take($count_user)->get();
    //                 foreach($users as $item){
    //                     $item->is_active = 1;
    //                     $item->save();
    //                 }
    //             }
    //         }elseif($plan->max_user == -1){
    //             $users = User::where('created_by',$user->id)->get();
    //             foreach($users as $item){
    //                 $item->is_active = 1;
    //                 $item->save();
    //             }
    //         }
    //         $user->plan = $plan->id;
    //         $user->total_user = $plan->max_user;
    //         $user->save();
    //         return redirect()->back()->with('success', __('Plan Subscribe successfully!'));

    //     } else  {
    //         return redirect()->back()->with('error', __('Permission denied.'));

    //     }
    // }

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
