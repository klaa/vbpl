@extends('admin.dashboard')

@section('pagetitle',__('admin.permission_create'))

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
    <h1 class="h3 mb-0 text-gray-800">{{ __('admin.group_permission') }}</h1>
</div>    
@endsection

@section('content')
<form action="{{ route('admin.permissions.store') }}" method="POST">
    @csrf
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{ __('admin.permission_create') }}</h6>
        </div>
        <div class="card-body">                
            <div class="form-row">
                <div class="form-group col">
                    <label for="formName">{{ __('admin.name') }}</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="formName" aria-describedby="nameHelp" required autofocus>
                    {{-- <small id="nameHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                </div>
                <div class="form-group col">
                    <label for="formAlias">{{ __('admin.alias') }}</label>
                    <input type="text" name="alias" value="{{ old('alias') }}" class="form-control @error('alias') is-invalid @enderror" id="formAlias" aria-describedby="aliasHelp">
                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label for="itemType">{{ __('admin.permission_type') }}</label>
                    <select name="type" id="itemType" class="form-control">
                        <option value="dashboard">{{ __('admin.dashboard') }}</option>
                        <option value="post">{{ __('admin.post') }}</option>
                        <option value="category">{{ __('admin.post_category') }}</option>
                        <option value="user">{{ __('admin.user') }}</option>
                        <option value="group">{{ __('admin.user_group') }}</option>
                        <option value="permission">{{ __('admin.group_permission') }}</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-12">
                    <label>{{ __('admin.group_permission') }}</label>
                </div>
                
                @foreach ($groups as $item)
                    <div class="col-md-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="groups[]" value="{{ $item->id }}" id="groupCheck{{ $item->id }}">
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
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-warning"><i class="far fa-window-close text-white-50"></i> {{ __('admin.cancel') }}</a>
        </div>
    </div>
</form>
@endsection