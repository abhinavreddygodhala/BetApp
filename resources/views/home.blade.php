@extends('layouts.app')

@section('content')
    <script>
        var button = document.querySelector('#submit-button');

        braintree.dropin.create({
            authorization: "{{ Braintree_ClientToken::generate() }}",
            container: '#dropin-container'
        }, function (createErr, instance) {
            button.addEventListener('click', function () {
                instance.requestPaymentMethod(function (err, payload) {
                    $.get('{{ route('payment.process') }}', {payload}, function (response) {
                        if (response.success) {
                            alert('PaymentController successfull!');
                        } else {
                            alert('PaymentController failed');
                        }
                    }, 'json');
                });
            });
        });
    </script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
