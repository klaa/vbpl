@extends('bk.general')

@section('pagetitle',$post->name)
    
@section('maincontent')
    <div class="bg-info text-white">
        <div class="container">
            <h6 class="py-4 text-uppercase">{{ $post->name }}</h6>
        </div>
    </div>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Văn bản pháp luật</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    @if ($post->post_type_2=='vbnn')
                        Văn bản nhà nước
                    @else
                        Văn bản trường
                    @endif
                </li>
            </ol>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-2 my-1">Mô tả ngắn</div>
            <div class="col-12 col-md-10 my-1">{{ $post->body }}</div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="row">
                    <div class="col-5 my-1">Ký hiệu văn bản</div>
                    <div class="col-7 my-1"><strong>{{ $post->kyhieu }}</strong></div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="row">
                    <div class="col-5 my-1">Ngày ban hành</div>
                    <div class="col-7 my-1"><strong>{{ $post->ngaybanhanh }}</strong></div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="row">
                    <div class="col-5 my-1">Trạng thái</div>
                    <div class="col-7 my-1"><strong>
                        @switch($post->trangthai)
                            @case(0)
                                Hết hiệu lực
                                @break
                            @case(1)
                                Còn hiệu lực
                                @break
                            @default
                                Chưa có hiệu lực
                        @endswitch
                    </strong></div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="row">
                    <div class="col-5 my-1">Lĩnh vực</div>
                    <div class="col-7 my-1"><strong>{{ $post->category->name }}</strong></div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="row">
                    <div class="col-5 my-1">Hiệu lực văn bản</div>
                    <div class="col-7 my-1"><strong>{{ $post->hieulucvb }}</strong></div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="row">
                    <div class="col-5 my-1">Tải về</div>
                    <div class="col-7 my-1"><a href="{{ asset($post->vanban) }}"><img src="{{ asset('images/ui.png') }}" alt="Tải về"></a></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col my-3">
                <div class="embed-responsive embed-responsive-16by9">
                    @if($post->extension=='pdf')
                        <embed class="embed-responsive-item" src="{{ asset($post->vanban) }}" type="application/pdf">
                    @else
                        <iframe class="embed-responsive-item" src="https://view.officeapps.live.com/op/view.aspx?&src={{ asset($post->vanban) }}" allowfullscreen></iframe>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection