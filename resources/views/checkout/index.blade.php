@extends('layouts.app')

@section('script')
    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('extra-meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="col-md-12">
        <p>
            Paiment ..
        </p>
        <div class="row">
            <div class="col-md-6">
                <form id="payment-form" class="my-4" action="{{route('checkout.store')}}" method="post">
                    @csrf
                    <div id="card-element">
                        <!-- Elements will create input elements here -->
                    </div>

                    <!-- We'll put the error messages in this element -->
                    <div id="card-errors" role="alert"></div>

                    <button id="submit" class="btn btn-success mt-4" type="submit">Pay</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        var stripe = Stripe('pk_test_65PYwXEiVATreY0KH2PnSVT000B4vs9Jzk');
        var elements = stripe.elements();

        var style = {
            base: {
                color: "#32325d",
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "#aab7c4"
                }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            }
        };

        var card = elements.create("card", {style: style});
        card.mount("#card-element");

        card.addEventListener('change', ({error}) => {
            const displayError = document.getElementById('card-errors');
            if (error) {
                displayError.classList.add('alert', 'alert-warning')
                displayError.textContent = error.message;
            } else {
                displayError.classList.remove('alert', 'alert-warning')
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');

        form.addEventListener('submit', function (ev) {
            ev.preventDefault();
            const button = document.getElementById('submit');
            button.disabled = true;

            stripe.confirmCardPayment('{{$clientSecret}}', {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: 'Jenny Rosen'
                    }
                }
            }).then(function (result) {
                const displayError = document.getElementById('card-errors');
                if (result.error) {
                    // Show error to your customer (e.g., insufficient funds)
                    displayError.classList.add('alert', 'alert-warning')
                    displayError.textContent = result.error.message
                    console.log(result.error.message);
                    button.disabled = false;
                } else {
                    // The payment has been processed!
                    if (result.paymentIntent.status === 'succeeded') {
                        displayError.classList.remove('alert', 'alert-warning')
                        displayError.textContent = '';

                        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        var payementItems = result.paymentIntent;
                        var url = form.action;
                        var redirect = '/merci'

                        fetch(
                            url,
                            {
                                headers: {
                                    "Content-Type": "application/json",
                                    "Accept": "application/json, text-plain, */*",
                                    "X-Requested-With": "XMLHttpRequest",
                                    "X-CSRF-TOKEN": token
                                },
                                method: "post",
                                body: JSON.stringify({
                                    payementItems: payementItems
                                })
                            }
                        ).then((data) => {
                            console.log(data)
                            window.location.href = redirect
                        })
                        .catch((error) => {
                            console.log(error)
                        })

                    }
                }
            });
        });
    </script>
@endsection
