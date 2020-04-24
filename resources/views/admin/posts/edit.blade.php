@extends('admin.dashboard')

@section('pagetitle',__('admin.post_edit'))

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.2.1/tinymce.min.js" integrity="sha256-6Q5EaYOf1K2LsiwJmuGtmWHoT1X/kuXKnuZeGudWFB4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.form-control').on('focus',function() {
                $(this).removeClass('is-invalid');
            });    
        });

        tinymce.init({
            selector: '.tinyMCE',
            height: 600,
            plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table directionality',
            'emoticons template paste textpattern imagetools'
            ],
            toolbar1: 'undo redo | styleselect | bold italic | table alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
            toolbar2: 'insertfile link image media | forecolor backcolor | code fullscreen preview',
            image_advtab: true,
            language : 'vi',
            language_url : '{{ asset("js/vi.js") }}',
            relative_urls : true,
            document_base_url : '{{ route("home") }}',
            file_picker_callback (callback, value, meta) {
                let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
                let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight

                tinymce.activeEditor.windowManager.openUrl({
                url : '{{ url('/file-manager/tinymce5') }}',
                title : '{{ __("admin.media_manager") }}',
                width : x * 0.8,
                height : y * 0.8,
                onMessage: (api, message) => {
                    callback(message.content, { text: message.text })
                }
                })
            },
        });
    </script>
@endpush

@section('pageheading')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __('admin.post_edit') }}</h1>
</div>    
@endsection

@section('content')
<form action="{{ route('admin.posts.update',$post) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{ __('admin.post_edit') }}</h6>
        </div>
        <div class="card-body">                
            <div class="form-row">
                <div class="form-group col">
                    <label for="formName">{{ __('admin.name') }}</label>
                    <input type="text" name="name" value="{{ $post->post_details->first()->name }}" class="form-control @error('name') is-invalid @enderror" id="formName" aria-describedby="nameHelp" required autofocus>
                    {{-- <small id="nameHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                </div>
                <div class="form-group col">
                    <label for="formAlias">{{ __('admin.alias') }}</label>
                    <input type="text" name="alias" value="{{ $post->post_details->first()->alias }}" class="form-control @error('alias') is-invalid @enderror" id="formAlias" aria-describedby="aliasHelp">
                    {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label>{{ __('admin.post_category') }}</label>
                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                        @foreach ($categories as $item)
                            <option @if($post->category_id==$item->id) selected @endif value="{{ $item->id }}">{{ $item->category_details->first()->name }}</option>
                        @endforeach
                    </select>
                </div>               
            </div>
            <div class="form-row">
                <div class="col form-group">
                    <label for="itemBody">{{ __('admin.body') }}</label>
                    <textarea name="body" id="itemBody" class="form-control tinyMCE">{{ $post->post_details->first()->body }}</textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="col form-group">
                    <label for="itemPublished">{{ __('admin.published') }}</label>
                    <div class="form-control border-0 px-0">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="published" id="publishYes" value="1" @if($post->published==1) checked @endif>
                            <label class="form-check-label" for="publishYes">{{ __('admin.yes') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="published" id="publishNo" value="0" @if($post->published==0) checked @endif>
                            <label class="form-check-label" for="publishNo">{{ __('admin.no') }}</label>
                        </div>
                    </div> 
                </div>
                <div class="col form-group">
                    <label for="itemFeatured">{{ __('admin.is_featured') }}</label>
                    <div class="form-control border-0 px-0">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_featured" id="featuredYes" value="1" @if($post->is_featured==1) checked @endif>
                            <label class="form-check-label" for="featuredYes">{{ __('admin.yes') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_featured" id="featureNo" value="0" @if($post->is_featured==0) checked @endif>
                            <label class="form-check-label" for="featureNo">{{ __('admin.no') }}</label>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label for="itemTitle">{{ __('admin.title') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="itemTitle" name="title" value="{{ $post->post_details->first()->title }}">
                    {{-- <small id="itemTitleHelp" class="form-text text-muted">Phục vụ SEO: tiêu đề của trang khi hiển thị bài viết này, sẽ hiển thị tên nếu tiều đề trống.</small> --}}
                </div>
                <div class="form-group col">
                    <label for="itemKeywords">{{ __('admin.keywords') }}</label>
                    <input type="text" class="form-control @error('keywords') is-invalid @enderror" id="itemKeywords" name="keywords" value="{{ $post->post_details->first()->keywords }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label for="itemDesc">{{ __('admin.desc') }}</label>
                    <textarea name="desc" class="form-control @error('desc') is-invalid @enderror" id="itemDesc" rows="3">{{ $post->post_details->first()->desc }}</textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button name="task" value="save" type="submit" class="btn btn-success"><i class="far fa-save text-white-50"></i> {{ __('admin.save') }}</button>
            <button name="task" value="saveandexit" type="submit" class="btn btn-success"><i class="fas fa-file-export text-white-50"></i> {{ __('admin.saveandexit') }}</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-warning"><i class="far fa-window-close text-white-50"></i> {{ __('admin.cancel') }}</a>
        </div>
    </div>
</form>
@endsection