<div class="table-responsive-md">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
              <th scope="col">Ký hiệu</th>
              <th scope="col">Ngày ban hành</th>
              <th scope="col">Tên văn bản</th>
              <th scope="col">Trạng thái</th>
              <th scope="col">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr class="table-light text-info">
                    <td><a href="{{ route('detail',$item) }}">{{ $item->kyhieu }}</a></td>
                    <td><a href="{{ route('detail',$item) }}">{{ $item->ngaybanhanh }}</a></td>
                    <td><strong><a href="{{ route('detail',$item) }}">{{ $item->name }}</a></strong></td>
                    <td>
                        @switch($item->trangthai)
                            @case(0)
                                Hết hiệu lực
                                @break
                            @case(2)
                                Chưa có hiệu lực
                                @break
                            @default
                                Có hiệu lực
                        @endswitch
                    </td>
                    <td><a href="{{ asset($item->vanban) }}" class="circle"><img src="{{ asset('images/ui.png') }}" alt="Tải xuống" title="Tải xuống"></a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{$data->links()}}
</div>