@extends('auth.general')

@section('pagetitle',__('auth.register'))

@section('content')
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-3">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
            <div class="col-lg-7">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">{{ __('auth.register') }}</h1>
                </div>
                <form class="user" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-user @error('name') is-invalid @enderror" required autofocus id="exampleFirstName" placeholder="{{ __('admin.name') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="username" value="{{ old('username') }}" required class="form-control form-control-user @error('username') is-invalid @enderror" id="exampleUserName" placeholder="{{ __('admin.username') }}">
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror    
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" value="{{ old('email') }}" required class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="{{__('admin.user_email') }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror    
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" required id="exampleInputPassword" placeholder="{{ __('admin.user_password') }}">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                      <div class="col-sm-6 mb-3 mb-sm-0">
                          <input type="password" name="password_confirmation" class="form-control form-control-user" id="exampleInputRePassword" placeholder="{{ __('auth.user_repassword') }}">    
                      </div>
                  </div>
                  <button class="btn btn-primary btn-user btn-block">{{__('auth.register')}}</button>
                  <hr>
                  <a href="#" class="btn btn-google btn-user btn-block">
                    <i class="fab fa-google fa-fw"></i> {{__('auth.login_with_google')}}
                  </a>
                  <a href="#" class="btn btn-facebook btn-user btn-block">
                    <i class="fab fa-facebook-f fa-fw"></i> {{__('auth.login_with_facebook')}}
                  </a>
                </form>
                <hr>
                <div class="text-center">
                  <a class="small" href="{{ route('password.request') }}">{{__('auth.forgot_pass')}}</a>
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
@endsection
