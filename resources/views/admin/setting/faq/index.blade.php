@extends('admin.layout.layout')


@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header">
                        <h2 class="box-title text-uppercase text-bold">{{$page_title}}</h2>
                        <div class="pull-right box-tools">
                            <div class="float-right mt-1">
                                <a class="btn bg-light-blue-active uppercase text-bold" href="{{ route('faqs.create') }}"> New FAQ</a>
                            </div>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="table-responsive">
                            <div class="col-lg-12">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="" class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-bold text-uppercase">#SL</th>
                                                    <th class="text-bold text-uppercase">Faq Title</th>
                                                    <th class="text-bold text-uppercase">Faq Description</th>
                                                    <th class="text-bold text-uppercase">Faq Status</th>
                                                    <th class="text-bold text-uppercase">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($faqs as $key => $faq)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ Str::limit($faq->title, 50) }}</td>
                                                    <td>{!! Str::limit($faq->description, 50, ' ...') !!}</td>
                                                    <td>
                                                        @if($faq->status == 1)
                                                            <label for="" class="badge bg-green-gradient fa fa-check"> Active</label>
                                                        @else
                                                            <label for="" class="badge bg-red-gradient fa fa-times"> Deactivated</label>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-primary fa fa-edit" href="{{ route('faqs.edit',$faq->id) }}"> Edit</a>
                                                        @can('delete')
                                                            {!! Form::button('<i class="fa fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-danger bold uppercase delete_button','data-toggle'=>"modal",'data-target'=>"#DelModal",'data-id'=>$faq->id]) !!}
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->
    </section>
    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" >
                <div class="modal-header bg-orange-active text-center">
                    <h4 class="modal-title" id="myModalLabel2"><i class='fa fa-trash'></i> Delete !</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Are you sure you want to Delete ?</strong>
                </div>
                <div class="modal-footer">
                    <form action="{{route('faqs.destroy',0)}}" method="post" id="deleteForm">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <input type="hidden" name="id" id="delete_id" class="delete_id" value="0">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-danger deleteButton"><i class="fa fa-trash"></i> DELETE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $(document).on("click", '.delete_button', function (e) {
                var id = $(this).data('id');
                var url = '{{ route("faqs.destroy",":id") }}';
                url = url.replace(':id',id);
                $("#deleteForm").attr("action",url);
                $("#delete_id").val(id);
            });
        });
    </script>
@endpush