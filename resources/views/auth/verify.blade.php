@extends('auth.general')

@section('pagetitle',__('auth.resend_verify_email'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('auth.fresh_verification_email_sent') }}
                                </div>
                            @endif
                            <h1 class="h4 text-gray-900 mb-2">{{__('auth.resend_verify_email')}}</h1>
                            <p class="mb-0">{{__('auth.check_verification_email')}}</p>
                            <p>{{ __('auth.if_not_receive_verification') }} 
                                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-info">{{ __('auth.request_another_email') }}</button>
                                </form>
                            </p>
                            </div>
                            <hr>
                            <div class="text-center">
                            <a class="small" href="{{ route('register') }}">{{__('auth.register')}}</a>
                            </div>
                            <div class="text-center">
                            <a class="small" href="{{ route('login') }}">{{__('auth.already_register')}}</a>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
