@extends('admin.dashboard')

@section('pagetitle',__('admin.user_management'))

@push('scripts')
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>    
    <script>
        $(document).ready(function() {
            //For data table
            $('#dataTable').DataTable({
                "ajax": "{{ route('admin.users.datatable') }}",
                "deferRender": true,
                "language": {
                                "decimal":        "",
                                "emptyTable":     "{{ __('admin.no_data') }}",
                                "info":           "{{ __('admin.datatable_show') }} _START_ {{ __('admin.datatable_to') }} _END_ of _TOTAL_ {{ __('admin.datatable_entries') }}",
                                "infoEmpty":      "{{ __('admin.datatable_show') }} 0 {{ __('admin.datatable_to') }} 0 {{ __('admin.datatable_of') }} 0 {{ __('admin.datatable_entries') }}",
                                "infoFiltered":   "({{ __('admin.filtered_from') }} _MAX_ {{ __('admin.datatable_entries') }})",
                                "infoPostFix":    "",
                                "thousands":      ",",
                                "lengthMenu":     "{{ __('admin.datatable_show') }} _MENU_ {{ __('admin.datatable_entries') }}",
                                "loadingRecords": "{{ __('admin.loading') }}",
                                "processing":     "{{ __('admin.processing') }}",
                                "search":         "{{ __('admin.search') }}:",
                                "zeroRecords":    "{{ __('admin.not_found') }}",
                                "paginate": {
                                    "first":      "{{ __('admin.paginate_first') }}",
                                    "last":       "{{ __('admin.paginate_last') }}",
                                    "next":       "{{ __('admin.paginate_next') }}",
                                    "previous":   "{{ __('admin.paginate_previous') }}"
                                },
                                "aria": {
                                    "sortAscending":  ": activate to sort column ascending",
                                    "sortDescending": ": activate to sort column descending"
                                }
                            }
            });
            //For delete modal
            $('#dataTable').on('click','.deleteButton',function() {
                var actionUrl = $(this).data('action');
                console.log(actionUrl);
                $('#deleteForm').attr('action',actionUrl);
            });
        });    
    </script>    
@endpush

@section('pageheading')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __('admin.user_management') }}</h1>
    @can('user-create')
    <div class="btnwrapper">
        <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success shadow-sm"><i class="fas fa-user-plus fa-sm text-white-50"></i> {{ __('admin.user_create') }}</a>
    </div>
    @endcan
</div>    
@endsection

@section('content')    

    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{ __('admin.list') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('admin.name') }}</th>
                            <th>{{ __('admin.user_email') }}</th>
                            <th>{{ __('admin.user_group') }}</th>
                            <th>{{ __('admin.published') }}</th>
                            <th>{{ __('admin.action') }}</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('admin.name') }}</th>
                            <th>{{ __('admin.user_email') }}</th>
                            <th>{{ __('admin.user_group') }}</th>
                            <th>{{ __('admin.published') }}</th>
                            <th>{{ __('admin.action') }}</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <!-- Data wil be rendered here after ajax -->
                    </tbody>    
                </table>
            </div>
        </div>
    </div>

    <!-- delete Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">{{ __('admin.are_you_sure') }}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">{{ __('admin.select_delete') }}</div>
            <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('admin.cancel') }}</button>
            <form id="deleteForm" action="#" method="POST">
                @csrf
                @method("DELETE")
                <button type="submit" class="btn btn-danger">{{ __('admin.delete') }}</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    
@endsection