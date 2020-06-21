@extends('admin.dashboard')

@section('pagetitle',__('admin.category_create'))

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
    <h1 class="h3 mb-0 text-gray-800">{{ __('admin.post_category') }}</h1>
</div>    
@endsection

@section('content')
<form action="{{ route($routeList['store']) }}" method="POST">
    @csrf
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{ __('admin.group_create') }}</h6>
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
                    <label>{{ __('admin.parent_category') }}</label>
                    <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                        <option value="0">{{ __('admin.no_parent') }}</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->category_details->first()->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col form-group">
                    <label for="itemPublished">{{ __('admin.published') }}</label>
                    <div class="form-control border-0">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="published" id="publishYes" value="1" checked>
                            <label class="form-check-label" for="publishYes">{{ __('admin.yes') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="published" id="publishNo" value="0">
                            <label class="form-check-label" for="publishNo">{{ __('admin.no') }}</label>
                        </div>
                    </div> 
                </div>               
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label for="itemTitle">{{ __('admin.title') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="itemTitle" name="title" value="{{ old('title') }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label for="itemKeywords">{{ __('admin.keywords') }}</label>
                    <input type="text" class="form-control @error('keywords') is-invalid @enderror" id="itemKeywords" name="keywords" value="{{ old('keywords') }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label for="itemDesc">{{ __('admin.desc') }}</label>
                    <textarea name="desc" class="form-control @error('desc') is-invalid @enderror" id="itemDesc" rows="5">{{ old('desc') }}</textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button name="task" value="save" type="submit" class="btn btn-success"><i class="far fa-save text-white-50"></i> {{ __('admin.save') }}</button>
            <button name="task" value="saveandexit" type="submit" class="btn btn-success"><i class="fas fa-file-export text-white-50"></i> {{ __('admin.saveandexit') }}</button>
            <a href="{{ route($routeList['index']) }}" class="btn btn-warning"><i class="far fa-window-close text-white-50"></i> {{ __('admin.cancel') }}</a>
        </div>
    </div>
</form>
@endsection