<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plan;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\PaymentIntent;

class StripePaymentController extends Controller
{
    public function stripePost(Request $request)
    {
        $planID         = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan           = Plan::find($planID);
        $authuser       = Auth::user();
        $data           = $request->all();
        $stripe_session = '';
        $Settings       = Setting::pluck('value', 'name');

        if ($plan) {
            $product = $plan->name;
            $P_price = $plan->price;

            /* Final price */
            // $stripe_formatted_price = in_array($this->currancy, [
            $stripe_formatted_price = in_array('USD', [
                'MGA', 'BIF', 'CLP', 'PYG', 'DJF', 'RWF', 'GNF', 'UGX', 'JPY', 'VND', 'VUV', 'XAF', 'KMF', 'KRW', 'XOF', 'XPF',
            ]) ? number_format($P_price, 2, '.', '') : number_format($P_price * 100, 0, '', '');
            $return_url_parameters = function ($return_type) {
                return '&return_type=' . $return_type .  '&payment_processor=stripe';
            };

            \Stripe\Stripe::setApiKey($Settings['stripe_secret_key']);
            // \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $price = \Stripe\Price::create([
                'product' => $plan->id,
                'unit_amount' => $stripe_formatted_price,
                'currency' => 'usd',
                'recurring' => ['interval' => 'month'],
            ]);

            $stripe_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price' => $price ? $price->id : null,
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'subscription',
                'metadata' => [
                    'user_id' => $authuser->id,
                    'package_id' => $plan->id,
                ],
                'success_url' => route('stripe.payment.status', [
                    'plan_id' => $plan->id,
                    'price' => $P_price,
                ]) . $return_url_parameters('success'),
                'cancel_url' => route('stripe.payment.status', [
                    'plan_id' => $plan->id,
                ]) . $return_url_parameters('cancel'),
            ]);

            // session()->put('beauty_spa_variable', $data);
            $request->session()->put('stripe_session', $stripe_session);
            $stripe_session = $stripe_session ?? false;

            return view('plan.stripe', compact('stripe_session', 'plan'));
            // return redirect()->route('plans.index', $request->plan_id)->with(['stripe_session' => $stripe_session]);
        } else {
            return redirect()->route('payment', $request->plan_id)->with('error', __('Plan is deleted.'));
        }
    }

    public function planGetStripePaymentStatus(Request $request)
    {
        // Session::forget('stripe_session');
        try {
            if ($request->return_type == 'success') {
                $objUser        = Auth::user();

                $plan           = Plan::find($request['plan_id']);
                $orderID        = strtoupper(str_replace('.', '', uniqid('', true)));
                $Settings       = Setting::pluck('value', 'name');

                $stripe_session = session()->get('stripe_session');

                $stripe = new \Stripe\StripeClient($Settings['stripe_secret_key']);

                // $paymentMethod = $stripe->paymentIntents->retrieve(
                //     $request->session()->get('stripe_session')->payment_intent,
                //     []
                //   );

                Order::create(
                    [
                        'order_id' => $orderID,
                        'name' => $plan->name,
                        // 'card_number' => isset($paymentMethod->card->last4) ? $paymentMethod->card->last4 : '',
                        // 'card_exp_month' => isset($paymentMethod->card->exp_month) ? $paymentMethod->card->exp_month : '',
                        // 'card_exp_year' => isset($paymentMethod->card->exp_year) ? $paymentMethod->card->exp_year : '',
                        'card_number' => '',
                        'card_exp_month' => '',
                        'card_exp_year' => '',
                        'plan_name' => $plan->name,
                        'plan_id' => $plan->id,
                        'price' => $request->price,
                        'price_currency' => '',
                        'payment_status' => '',
                        'payment_type' => __('STRIPE'),
                        'user_id' => $objUser->id,
                    ]
                );

                $assignPlan     = $objUser->assignPlan($request->plan_id);
                if ($request->return_type == 'success') {
                    return redirect()->route('plans.index')->with('success', __('Plan activated Successfully!'));
                } else {
                    return redirect()->route('plans.index')->with('error', __($assignPlan['error']));
                }
            } else {
                return redirect()->back()->with('error', __('Your Payment has failed!'));
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
