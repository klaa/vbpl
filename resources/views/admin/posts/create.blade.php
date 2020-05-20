@extends('admin.dashboard')

@section('pagetitle',__('admin.post_create'))

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.2.1/tinymce.min.js" integrity="sha256-6Q5EaYOf1K2LsiwJmuGtmWHoT1X/kuXKnuZeGudWFB4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.form-control').on('focus',function() {
                $(this).removeClass('is-invalid');
            });
            $('#button-image').click(function(event) {
                event.preventDefault();
                window.open('/file-manager/fm-button', '{{ __("admin.media_manager") }}', 'width=800,height=600,menubar=0,scrollbars=0,resizable=0,location=0,toolbar=0,titlebar=0');
            });
            $('#mediaList').on('click','.deleteMedia',function() {
                $(this).parent().remove();
            });    
        });

        function fmSetLink($url) {
            var link = $url.replace('{{ config("app.url") }}/','');
            document.getElementById('mediaAdd').value = link;
            $('#mediaList').prepend('<div class="col-3 mb-2"><img src="'+$url+'" class="img-fluid" /><input type="hidden" name="medialist[]" value="'+link+'"><button type="button" class="deleteMedia btn btn-sm btn-danger mt-1 btn-block"><i class="fas fa-trash"></i> {{ __("admin.delete") }}</button>  </div>');            
        } 

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
                url : '{{ route("fm.tinymce5") }}',
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
    <h1 class="h3 mb-0 text-gray-800">{{ __('admin.post_create') }}</h1>
</div>    
@endsection

@section('content')
<form action="{{ route('admin.posts.store') }}" method="POST">
    @csrf
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <ul class="nav nav-pills m-0" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-details-tab" data-toggle="tab" href="#pills-details" role="tab" aria-controls="pills-details" aria-selected="true">{{ __('admin.details') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-media-tab" data-toggle="tab" href="#pills-media" role="tab" aria-controls="pills-media" aria-selected="true">{{ __('admin.media') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-seo-tab" data-toggle="tab" href="#pills-seo" role="tab" aria-controls="pills-seo" aria-selected="false">{{ __('admin.metadata') }}</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="pills-details" role="tabpanel" aria-labelledby="pills-details-tab">                
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
                            <label>{{ __('admin.post_category') }}</label>
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->category_details->first()->name }}</option>
                                @endforeach
                            </select>
                        </div>               
                    </div>
                    <div class="form-row">
                        <div class="col form-group">
                            <label for="itemBody">{{ __('admin.body') }}</label>
                            <textarea name="body" id="itemBody" class="form-control tinyMCE">{{ old('body') }}</textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-6 form-group">
                            <label for="itemOrdering">{{ __('admin.ordering') }}</label>
                            <input type="number" name="ordering" id="itemOrdering" class="form-control" value="{{ old('ordering')?old('ordering'):0 }}">
                        </div>
                        <div class="col-3 form-group">
                            <label for="itemPublished">{{ __('admin.published') }}</label>
                            <div class="form-control border-0 px-0">
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
                        <div class="col-3 form-group">
                            <label for="itemFeatured">{{ __('admin.is_featured') }}</label>
                            <div class="form-control border-0 px-0">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_featured" id="featuredYes" value="1">
                                    <label class="form-check-label" for="featuredYes">{{ __('admin.yes') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_featured" id="featureNo" value="0" checked>
                                    <label class="form-check-label" for="featureNo">{{ __('admin.no') }}</label>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="pills-media" role="tabpanel" aria-labelledby="pills-media-tab">
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="itemMediaShowType">{{ __('admin.media_show_type') }}</label>
                            <div class="form-control border-0 px-0">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="media_display" id="mediaShowCarousel" value="0" checked>
                                    <label class="form-check-label" for="mediaShowCarousel">{{ __('admin.media_show_carousel') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="media_display" id="mediaShowGallery" value="1">
                                    <label class="form-check-label" for="mediaShowGallery">{{ __('admin.media_show_gallery') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span id="button-image" class="btn btn-info">{{ __('admin.media_add') }}</span>
                                </div>
                                <input type="text" id="mediaAdd" class="form-control" name="media_add" aria-label="Image" aria-describedby="button-image">
                            </div>
                        </div>
                    </div>
                    <div id="mediaList" class="row">
                    </div>                    
                </div>
                <div class="tab-pane" id="pills-seo" role="tabpanel" aria-labelledby="pills-seo-tab">
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="itemTitle">{{ __('admin.title') }}</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="itemTitle" name="title" value="{{ old('title') }}" aria-describedby="itemTitleHelp">
                            <small id="itemTitleHelp" class="form-text text-muted">Tiêu đề trang.</small>
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
                            <textarea name="desc" class="form-control @error('desc') is-invalid @enderror" id="itemDesc" rows="3">{{ old('desc') }}</textarea>
                        </div>
                    </div>
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