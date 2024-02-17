@extends('layouts.main')

@section('title')
    {{ __('Plan Payment') }}
@endsection
@section('page-breadcrumb')
    {{ __('Plan Payment') }}
@endsection

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center mb-3">
                <div class="col-md-10">
                </div>
                <div class="col-md-2">
                    <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="stripe-tab" data-bs-toggle="pill"
                                data-bs-target="#stripe" type="button">{{ __('Stripe Payment') }}</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        {{ Form::open(['route' => 'stripe.post', 'method'=>'POST','class'=>'require-validation', 'id'=>'payment-form']) }}
        @csrf
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="stripe" role="tabpanel" aria-labelledby="pills-stripe-tab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Stripe Payment</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="card-name-on"
                                            class="form-label">{{ __('Name on card') }}</label>
                                        <input type="text" name="name" id="card-name-on"
                                            class="form-control required"
                                            placeholder="{{ \Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="card-name-on"
                                            class="form-label">{{ __('Payment Details') }}</label>
                                            <div id="card-element"></div>
                                            <div id="card-errors" role="alert"></div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="stripe_coupon"
                                            class="form-label text-dark">{{ __('Coupon') }}</label>
                                        <input type="text" id="stripe_coupon" name="coupon"
                                            class="form-control coupon" data-from="stripe"
                                            placeholder="{{ __('Enter Coupon Code') }}">
                                    </div>
                                </div>
                                <div class="col-md-1 coupon-apply-btn mt-4">
                                    <div class="form-group apply-stripe-btn-coupon">
                                        <a href="#"
                                            class="btn btn-primary align-items-center apply-coupon"
                                            data-from="stripe">{{ __('Apply') }}</a>
                                    </div>
                                </div>
                                <div class="col-12 text-right stripe-coupon-tr" style="display: none">
                                    <b>{{ __('Coupon Discount') }}</b> : <b class="stripe-coupon-price"></b>
                                </div>
                                <div class="mt-4">
                                    <div class="col-sm-12">
                                        <div class="float-end">
                                            <input type="hidden" name="plan_id"
                                                value="{{ \Illuminate\Support\Facades\Crypt::encrypt($plan->id) }}">
                                            <button class="btn btn-primary d-flex align-items-center"
                                                type="submit">
                                                <i class="mdi mdi-cash-multiple mr-1"></i> {{ __('Pay Now') }}
                                                {{-- (<span
                                                    class="stripe-final-price">{{ $admin_payment_setting['currency_symbol'] }}{{ $plan->price }}</span>) --}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{Form::close()}}
    </div>
@endsection

@push('after-scripts')

<script src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">
        var stripe = Stripe('pk_test_aLoicAw16w12wxLlmI9uluaf008XMnn2VJ');
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        var style = {
            base: {
                // Add your base input styles here. For example:
                fontSize: '14px',
                color: '#32325d',
            },
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {
            style: style
        });

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');
        // Create a token or display an error when the form is submitted.
        var form = document.getElementById('payment-form');

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    $("#card-errors").html(result.error.message);
                    toastrs('Error', result.error.message, 'error');
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            // Submit the form
            form.submit();
        }
</script>

@endpush
