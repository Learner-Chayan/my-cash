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
                                    <button class="btn text-light btn-primary" data-target="#createAsset" data-toggle="modal">Asset Add</button>
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
                                        <th class="text-bold text-uppercase">Title</th>
                                        <th class="text-bold text-uppercase">Status</th>
                                        <th class="text-bold text-uppercase">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($assets as $key => $asset)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $asset->title }}</td>
                                            <td>{{ $asset->status}}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary fa fa-edit" data-toggle="modal" data-target="#assetEdit" onclick="showFormData({{$asset}})"> Edit</button>
{{--                                                @can('delete')--}}
{{--                                                    <button title="Delete" class="btn btn-sm btn-danger bold uppercase delete_button" data-toggle="modal" data-target="#DelModal" data-id="{{ $asset->id }}">--}}
{{--                                                        <i class="fa fa-trash"></i>--}}
{{--                                                    </button>--}}
{{--                                                @endcan--}}
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

    <!-- Create Modal -->
    <div id="createAsset" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form enctype="multipart/form-data" id="storeAsset">
                        <div class="form-group">
                            <label>Asset Title <code>*</code></label>
                            <input type="text" class="form-control" required name="title" placeholder="Asset Title">
                        </div>
                        <div class="form-group">
                            <label>Status<code>*</code></label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="1">Unlock</option>
                                <option value="2">Lock</option>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" id="submit-edit" class="btn text-light btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit -->
    <div id="assetEdit" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form enctype="multipart/form-data" id="assetUpdate">
                        <input type="hidden" id="edit_asset_id" name="asset_id">
                        <div class="form-group">
                            <label>Asset Title<code>*</code></label>
                            <input type="text" class="form-control" id="edit_title" required name="title" placeholder="Asset Title">
                        </div>
                        <div class="form-group">
                            <label>Status<code>*</code></label>
                            <select name="status" id="edit_status" class="form-control" required>
                                <option value="1">Unlock</option>
                                <option value="2">Lock</option>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" id="submit-edit" class="btn text-light btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete modal -->
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
            $('#storeAsset').on('submit',(function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var formData;
                formData = new FormData(this);
                $.ajax({

                    type:'POST',
                    url: "{{route('asset.store')}}",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,

                    success: function(data) {
                        // console.log(data)
                        if($.isEmptyObject(data.error)){
                            setTimeout(() => {
                                // toastr.success("Successfully Save Data!");
                                location.reload();
                            },500)
                        }else{
                            printErrorMsg(data.error);
                        }
                    }
                });

                $('#createAsset').modal('toggle');

            }));
            $('#assetUpdate').on('submit',(function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var formData;
                formData = new FormData(this);
                $.ajax({

                    type:'POST',
                    url: "{{route('asset-update')}}",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,

                    success: function(data) {
                        console.log(data)
                        if($.isEmptyObject(data.error)){
                            setTimeout(() => {
                                location.reload();
                            },500)
                        }else{
                            printErrorMsg(data.error);
                        }
                    }
                });


                $('#assetEdit').modal('toggle');

            }));
            function printErrorMsg (msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display','block');
                $.each( msg, function( key, value ) {
                    // toastr.warning(value);
                    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                });
            }
            $(document).on("click", '.delete_button', function (e) {
                var id = $(this).data('id');
                var url = '{{ route("users.destroy",":id") }}';
                url = url.replace(':id',id);
                $("#deleteForm").attr("action",url);
                $("#delete_id").val(id);
            });
        });
        function showFormData(data){
            console.log('helo')
            $("#edit_asset_id").val(data.id);
            $("#edit_title").val(data.title);
            $('#edit_status').val(data.status).trigger('change');
        }
    </script>
@endpush
