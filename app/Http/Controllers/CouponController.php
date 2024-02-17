<?php

namespace App\Http\Controllers;

use App\Models\Coupons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if((Auth::user()->can('manage coupons')))
        // {
        $coupons = Coupons::get();
        return view('coupon.index', compact('coupons'));

        // }   else  {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if (Auth::user()->can('create coupons'))
        // {
        return view('coupon.create');
        // }else{
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // if (Auth::user()->can('create coupons')) {
            $validatorArray = [
                'name' => 'required|max:120',
                'coupon_code' => 'required',
                'coupon_exp_date' => 'required|date|after:today',
                'discount' => 'required',
                'limit' => 'required',
            ];
            $validator = Validator::make(
                $request->all(),
                $validatorArray
            );
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $coupons = new Coupons();
            $coupons->name = $request->name;
            $coupons->coupon_code = $request->coupon_code;
            $coupons->coupon_exp_date = $request->coupon_exp_date;
            $coupons->duration = $request->duration;
            $coupons->discount = $request->discount;
            $coupons->limit = $request->limit;
            $coupons->description = $request->description;
            $coupons->is_active = $request->is_active;
            $coupons->save();
            return redirect()->back()->with('success', __('Coupon create successfully!'));
        // } else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupons $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupons $coupon)
    {
        // if (Auth::user()->can('edit coupons'))
        // {
        return view('coupon.edit');
        // }else{
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // if (Auth::user()->can('edit coupons'))
        // {
            $validatorArray = [
                'name' => 'required|max:120',
                'coupon_code' => 'required',
                'coupon_exp_date' => 'required|date|after:today',
                'discount' => 'required',
                'limit' => 'required',
            ];
            $validator = Validator::make(
                $request->all(),
                $validatorArray
            );
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $coupons = Coupons::findOrFail($id);
            $coupons->name = $request->name;
            $coupons->coupon_code = $request->coupon_code;
            $coupons->coupon_exp_date = $request->coupon_exp_date;
            $coupons->duration = $request->duration;
            $coupons->discount = $request->discount;
            $coupons->limit = $request->limit;
            $coupons->description = $request->description;
            $coupons->is_active = $request->is_active;
            $coupons->save();
            return redirect()->back()->with('success', __('Coupon update successfully!'));
        // } else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // if(Auth::user()->can('delete coupons'))
        // {
            $Coupons = Coupons::findOrFail($id);
            try {
                $Coupons->delete();
            }
            catch (\Exception $e)
            {
                return redirect()->back()->with('error', __($e->getMessage()));
            }

            return redirect()->route('coupons.index')->with('success','Coupon deleted successfully');
        // } else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }
}
