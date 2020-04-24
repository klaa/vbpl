@extends('auth.general')

@section('pagetitle',__('auth.confirm_password'))

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
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <h1 class="h4 text-gray-900 mb-2">{{__('auth.confirm_password')}}?</h1>
                            <p class="mb-4">{{__('auth.confirm_password_before_continue')}}</p>
                            </div>
                            <form class="user" method="POST" action="{{ route('password.confirm') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="password" name="password" value="{{ old('password') }}" required autofocus class="form-control form-control-user @error('password') is-invalid @enderror" id="exampleInputpassword" aria-describedby="passwordHelp" placeholder="{{__('auth.password')}}">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    {{__('auth.confirm_password')}}
                                </button>
                            </form>
                            <hr>
                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a class="small" href="{{ route('password.request') }}">{{__('auth.forgot_pass')}}</a>
                                </div>
                            @endif
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
