@extends('bk.general')

@section('pagetitle','Văn bản pháp luật')

@push('js')
    <script>
        jQuery(document).ready(function() {
            jQuery('#frmLinhVuc').on('change',function() {
                jQuery('#formFilter').submit();      
            });
        });    
    </script>    
@endpush
    
@section('maincontent')
    <div class="bg-info text-white">
        <div class="container">
            <h5 class="py-4 text-uppercase">Văn bản Pháp luật - Đại học Thái Nguyên</h5>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <ul class="typenav nav nav-pills">
                    <li class="nav-item mr-1">
                        <a class="nav-link @if(!request()->filled('vbt')) active @endif" id="nav-vbnn-tab" data-toggle="tab" data-type="vbnn" href="#nav-vbnn" role="tab" aria-controls="nav-vbnn" aria-selected="true">Văn bản nhà nước</a>
                    </li>
                    <li class="nav-item">    
                        <a class="nav-link @if(request()->filled('vbt')) active @endif" id="nav-vbt-tab" data-toggle="tab" data-type="vbt" href="#nav-vbt" role="tab" aria-controls="nav-vbt" aria-selected="false">Văn bản trường</a>
                    </li>    
                </ul>
                <div class="filterForm mt-2">
                    <form action="{{ route('home') }}" method="POST" id="formFilter">
                        @csrf
                        <input type="hidden" name="post_type_2" value="vbnn">
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="frmLinhVuc">Lĩnh vực</label>
                                <select name="category_id" id="frmLinhVuc" class="form-control form-control-sm">
                                    <option value="">Tất cả lĩnh vực</option>
                                    @foreach ($linhvuc as $item)
                                        <option @if(request()->get('category_id')==$item->id) selected @endif value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="nothins" class="d-none d-lg-block">&nbsp;</label>
                                <button type="button" data-toggle="collapse" data-target=".advancedsearch" class="btn btn-block btn-outline-info btn-sm">Tìm kiếm nâng cao</button>
                            </div>
                        </div>
                        <div class="form-row collapse advancedsearch">
                            <div class="form-group col">
                                <label for="frmNgaybanhanh">Ngày ban hành</label>
                                <input id="frmNgaybanhanh" type="date" name="ngaybanhanh" class="form-control form-control-sm" value="{{ request()->get('ngaybanhanh') }}">   
                            </div>
                            <div class="form-group col">
                                <label for="frmKyhieu">Ký hiệu</label>
                                <input id="frmKyhieu" type="text" name="kyhieu" class="form-control form-control-sm" value="{{ request()->get('kyhieu') }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="frmKeyword">Từ khóa</label>
                                <input id="frmKeyword" name="keyword" type="text" class="form-control form-control-sm" value="{{ request()->get('keyword') }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col text-center">
                                <button type="submit" class="btn btn-sm btn-outline-info px-5">Tìm kiếm</button>
                                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-warning px-5 resetbtn">Đặt lại</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade @if(!request()->filled('vbt')) show active @endif" id="nav-vbnn" role="tabpanel" aria-labelledby="nav-vbnn-tab">
                        @include('bk.listvb',['type'=>'vbnn','data'=>$vbnn])
                    </div>
                    <div class="tab-pane fade @if(request()->filled('vbt')) show active @endif" id="nav-vbt" role="tabpanel" aria-labelledby="nav-vbt-tab">
                        @include('bk.listvb',['type'=>'vbt','data'=>$vbt])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection