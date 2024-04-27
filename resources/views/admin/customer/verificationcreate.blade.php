@extends('admin.layout.layout')
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/assets')}}/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('/assets')}}/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush
@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- /.card -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{$page_title}}</h3>
                    <div class="pull-right box-tools">
                        <div class="float-right mt-1">
                            <a class="btn btn-primary uppercase text-bold" href="{{ route('users.index') }}"> Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('request-store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="customer_id" class="form-control">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">front</label>
                                    <input type="file" class="form-control"  name="front_side" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">back</label>
                                    <input type="file" class="form-control"  name="back_side" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">selfie</label>
                                    <input type="file" class="form-control"  name="selfie" >
                                </div>

                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Submit</button>

                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@push('js')
    <script src="{{asset('/assets')}}/select2/js/select2.full.min.js"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
        });

    </script>
@endpush
