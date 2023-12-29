@extends('admin.layout.layout')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('/assets')}}/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/assets')}}/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/assets')}}/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">{{$page_title}}</h3>
                            <div class="pull-right box-tools">
                                <div class="float-right mt-1">
                                    <a class="btn btn-primary uppercase text-bold" href="{{ route('users.create') }}"> New User</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-bold text-uppercase">#SL</th>
                                        <th class="text-bold text-uppercase">Name</th>
                                        <th class="text-bold text-uppercase">Email</th>
                                        <th class="text-bold text-uppercase">Phone</th>
                                        <th class="text-bold text-uppercase">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($assets as $key => $asset)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $asset->name }}</td>
                                            <td>{{ $asset->email }}</td>
                                            <td>{{ $asset->phone }}</td>

                                            <td>
                                                @if($asset->id !== 0)
                                                    <a class="btn btn-sm btn-primary fa fa-edit" href="{{ route('users.edit',$asset->id) }}" title="Edit"></a>
                                                    @can('delete')
                                                        <button title="Delete" class="btn btn-sm btn-danger bold uppercase delete_button" data-toggle="modal" data-target="#DelModal" data-id="{{ $asset->id }}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                     @endcan
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <div class="modal fade" id="DelModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to Delete ?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <form action="{{route('users.destroy',0)}}" method="post" id="deleteForm">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <input type="hidden" name="id" id="delete_id" class="delete_id" value="0">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger deleteButton float-right">Delete!</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@push('js')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('/assets')}}/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('/assets')}}/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('/assets')}}/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('/assets')}}/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{asset('/assets')}}/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{asset('/assets')}}/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{asset('/assets')}}/jszip/jszip.min.js"></script>
    <script src="{{asset('/assets')}}/pdfmake/pdfmake.min.js"></script>
    <script src="{{asset('/assets')}}/pdfmake/vfs_fonts.js"></script>
    <script src="{{asset('/assets')}}/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{asset('/assets')}}/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["excel", "pdf", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        $(document).ready(function () {
            $(document).on("click", '.delete_button', function (e) {
                var id = $(this).data('id');
                var url = '{{ route("users.destroy",":id") }}';
                url = url.replace(':id',id);
                $("#deleteForm").attr("action",url);
                $("#delete_id").val(id);
            });
        });
    </script>
@endpush
