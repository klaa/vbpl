@extends('admin.dashboard')

@section('pagetitle',__('admin.user_edit',['name'=>$user->name]))

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.form-control').on('focus',function() {
                $(this).removeClass('is-invalid');
            });    
        });
    </script>
@endpush

@section('pageheading')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __('admin.user_management') }}</h1>
</div>    
@endsection

@section('content')
<form action="{{ route('admin.users.update',$user) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{ __('admin.user_edit',['name'=>$user->name]) }}</h6>
        </div>
        <div class="card-body">  
            <div class="form-row">
                <div class="form-group col">
                    <label for="formName">{{ __('admin.name') }}</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control @error('name') is-invalid @enderror" id="formName" aria-describedby="nameHelp">
                    {{-- <small id="nameHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                </div>
                <div class="form-group col">
                    <label for="formEmail">{{ __('admin.user_email') }}</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror" id="formEmail" aria-describedby="emailHelp">
                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label for="formUserName">{{ __('admin.username') }}</label>
                    <input type="text" name="username" value="{{ $user->username }}" class="form-control @error('username') is-invalid @enderror" id="formUserName" aria-describedby="usernameHelp">
                    {{-- <small id="usernameHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}     
                </div>
                <div class="form-group col">
                    <label for="formPassword">{{ __('admin.user_password') }}</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="formPassword" aria-describedby="passwordHelp">
                    {{-- <small id="passwordHelp" class="form-text text-muted">We'll never share your password with anyone else.</small> --}}       
                </div>    
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label for="formPhone">{{ __('admin.user_phone') }}</label>
                    <input type="text" name="phone" class="form-control" id="formPhone" aria-describedby="phoneHelp">
                    {{-- <small id="phoneHelp" class="form-text text-muted">We'll never share your password with anyone else.</small> --}}       
                </div>
                <div class="form-group col">
                    <label for="formPublish">{{ __('admin.published') }}</label>
                    <div class="form-control border-0">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="published" id="publishYes" value="1" @if($user->published==1) {{ 'checked' }} @endif>
                            <label class="form-check-label" for="publishYes">{{ __('admin.yes') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="published" id="publishNo" value="0" @if($user->published==0) {{ 'checked' }} @endif>
                            <label class="form-check-label" for="publishNo">{{ __('admin.no') }}</label>
                        </div>
                    </div>      
                </div>        
            </div>
            <div class="form-row">
                <div class="col-12">
                    <label>{{ __('admin.user_group') }}</label>
                </div>
                @foreach ($groups as $item)
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="groups[]" @if($user->groups->contains('id',$item->id)) checked @endif value="{{ $item->id }}" id="groupCheck{{ $item->id }}">
                            <label class="form-check-label" for="groupCheck{{ $item->id }}">
                            {{ $item->name }}
                            </label>
                        </div>
                    </div>    
                @endforeach                   
            </div>    
        </div>
        <div class="card-footer">
            <button name="task" value="save" type="submit" class="btn btn-success"><i class="far fa-save text-white-50"></i> {{ __('admin.save') }}</button>
            <button name="task" value="saveandexit" type="submit" class="btn btn-success"><i class="fas fa-file-export text-white-50"></i> {{ __('admin.saveandexit') }}</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-warning"><i class="far fa-window-close text-white-50"></i> {{ __('admin.cancel') }}</a>
        </div>
    </div>
</form> 
@endsection