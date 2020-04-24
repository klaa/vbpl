@extends('auth.general')

@section('pagetitle',__('auth.forgot_pass'))

@section('content')
<div class="container">
    <!-- Outer Row -->
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
                      <h1 class="h4 text-gray-900 mb-2">{{__('auth.forgot_pass')}}?</h1>
                      <p class="mb-4">{{__('auth.we_will_send_email')}}</p>
                    </div>
                    <form class="user" method="POST" action="{{ route('password.email') }}">
                        @csrf
                      <div class="form-group">
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="{{__('auth.email_placeholer')}}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                      <button type="submit" class="btn btn-primary btn-user btn-block">
                          {{__('auth.reset_password')}}
                      </button>
                    </form>
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
