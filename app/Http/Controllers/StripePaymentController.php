<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Plan;
use App\Models\UseCoupon;
use Illuminate\Http\Request;
use Stripe;
use Illuminate\Support\Facades\Auth;

class StripePaymentController extends Controller
{
    public function stripePost(Request $request)
    {
        // $this->planpaymentSetting();

        $objUser = Auth::user();
        $planID  = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan    = Plan::find($planID);

        if ($plan)
        {
            try
            {
                $price = $plan->price;
                $orderID = strtoupper(str_replace('.', '', uniqid('', true)));

                // if (!empty($request->coupon))
                // {
                //     $coupons = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                //     if (!empty($coupons)) {
                //         $usedCoupun     = $coupons->used_coupon();
                //         $discount_value = ($plan->price / 100) * $coupons->discount;
                //         $price          = $plan->price - $discount_value;

                //         if ($usedCoupun >= $coupons->limit) {
                //             return redirect()->back()->with('error', __('This coupon code has expired.'));
                //         }
                //     } else {
                //         return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
                //     }
                // }

                if ($price > 0.0) {
                    // Stripe\Stripe::setApiKey($this->stripe_secret);
                    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                    $data = Stripe\Charge::create(
                        [
                            "amount" => 100 * $price,
                            "currency" => "inr",
                            "source" => $request->stripeToken,
                            "description" => " Plan - " . $plan->name,
                            "metadata" => ["order_id" => $orderID],
                        ]
                    );
                    dd($data);
                }
                else
                {
                    $data['amount_refunded']                             = 0;
                    $data['failure_code']                                = '';
                    $data['paid']                                        = 1;
                    $data['captured']                                    = 1;
                    $data['status']                                      = 'succeeded';
                    $data['payment_method_details']['card']['last4']     = '';
                    $data['payment_method_details']['card']['exp_month'] = '';
                    $data['payment_method_details']['card']['exp_year']  = '';
                    $data['currency']                                    = ($this->currancy) ? strtolower($this->currancy) : 'inr';
                    $data['receipt_url']                                 = 'free coupon';
                    $data['balance_transaction']                         = 0;
                }
                // dd($data);
                if ($data['amount_refunded'] == 0 && empty($data['failure_code']) && $data['paid'] == 1 && $data['captured'] == 1) {

                    Order::create(
                        [
                            'order_id' => $orderID,
                            'name' => $request->name,
                            'card_number' => isset($data['payment_method_details']['card']['last4']) ? $data['payment_method_details']['card']['last4'] : '',
                            'card_exp_month' => isset($data['payment_method_details']['card']['exp_month']) ? $data['payment_method_details']['card']['exp_month'] : '',
                            'card_exp_year' => isset($data['payment_method_details']['card']['exp_year']) ? $data['payment_method_details']['card']['exp_year'] : '',
                            'plan_name' => $plan->name,
                            'plan_id' => $plan->id,
                            'price' => $price,
                            'price_currency' => isset($data['currency']) ? $data['currency'] : '',
                            'txn_id' => isset($data['balance_transaction']) ? $data['balance_transaction'] : '',
                            'payment_status' => isset($data['status']) ? $data['status'] : 'succeeded',
                            'payment_type' => __('STRIPE'),
                            'receipt' => isset($data['receipt_url']) ? $data['receipt_url'] : 'free coupon',
                            'user_id' => $objUser->id,
                        ]
                    );

                    if (!empty($request->coupon)) {
                        $userCoupon         = new UseCoupon();
                        $userCoupon->user   = $objUser->id;
                        $userCoupon->coupon = $coupons->id;
                        $userCoupon->order  = $orderID;
                        $userCoupon->save();
                        $usedCoupun = $coupons->used_coupon();
                        if ($coupons->limit <= $usedCoupun) {
                            $coupons->is_active = 0;
                            $coupons->save();
                        }
                    }

                    if ($data['status'] == 'succeeded') {
                        $assignPlan = $objUser->assignPlan($plan->id);
                        if ($assignPlan['is_success']) {
                            return redirect()->route('plans.index')->with('success', __('Plan activated Successfully!'));
                        } else {
                            return redirect()->route('plans.index')->with('error', __($assignPlan['error']));
                        }
                    } else {
                        return redirect()->route('plans.index')->with('error', __('Your Payment has failed!'));
                    }
                } else {
                    return redirect()->route('plans.index')->with('error', __('Transaction has been failed!'));
                }
            } catch (\Exception $e) {
                return redirect()->route('plans.index')->with('error', __($e->getMessage()));
            }
        } else {
            return redirect()->route('plans.index')->with('error', __('Plan is deleted.'));
        }
    }
}
