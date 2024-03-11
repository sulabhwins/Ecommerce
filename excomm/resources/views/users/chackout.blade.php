@extends('users.layout.layout')
@section('contents')
<style>
    .hide {
        display: none;
    }
</style>
<h2>Addresses</h2>
<ul>
    @foreach ($savedAddresses as $address)
    <li>
        {{ $address->street_address }}, {{ $address->city }}, {{ $address->state }}, {{ $address->postal_code }}
    </li>
    @endforeach
</ul>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default credit-card-box">
                <div class="panel-body">

                    @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                    @endif

                    <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                        @csrf

                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card</label> <input class='form-control' size='4' type='text'>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Card Number</label> <input autocomplete='off' class='form-control inputs card-number' id='credit-card-input' maxlength='19' type='text'>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off' class='form-control inputs card-cvc' placeholder='ex. 311' maxlength='4' type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input class='form-control inputs card-expiry-month' placeholder='MM' maxlength='2' type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input class='form-control inputs card-expiry-year' placeholder='YYYY' maxlength='4' type='text'>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now {{Session::get('totalAmount')}}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
const inputs = document.querySelectorAll('.inputs');

inputs.forEach((input, index) => {
    input.addEventListener('input', function () {
        this.value = formatNumber(this.value.replaceAll(" ", ""));

        if (this.value.length == this.maxLength) {
            const nextInput = inputs[index + 1];

            if (nextInput) {
                nextInput.focus();
            } else {
                this.blur();
            }
        }
    });
});

const formatNumber = (number) => number.split("").reduce((seed, next, index) => {
    if (index !== 0 && !(index % 4)) seed += " ";
    return seed + next;
}, "");

</script>
@stop