@extends('auth.general')

@section('pagetitle',__('auth.login'))

@section('content')
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">{{ __('auth.login') }}</h1>
                    </div>
                    <form class="user" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <input onchange="event.preventDefault();document.getElementById('exampleInputUsername').value=this.value;" value="{{ old('email') }}" required autofocus type="text" name="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="{{ __('auth.username_field_placeholder') }}">
                            <input id="exampleInputUsername" type="hidden" value="{{ old('email') }}" name="username">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input required type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="{{ __('auth.password') }}">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" name="remember" class="custom-control-input" id="customCheck" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customCheck">{{ __('auth.remember_me') }}</label>
                            </div>
                        </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">{{ __('auth.login') }}</button>
                    <hr>
                    <a href="{{ route('google-login') }}" class="btn btn-google btn-user btn-block">
                      <i class="fab fa-google fa-fw"></i> {{__('auth.login_with_google')}}
                    </a>
                    <a href="#" class="btn btn-facebook btn-user btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> {{__('auth.login_with_facebook')}}
                    </a>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="{{ route('password.request') }}">{{ __('auth.forgot_pass') }}</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="{{ route('register') }}">{{ __('auth.register') }}</a>
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
