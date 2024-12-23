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
                            <a class="btn btn-primary uppercase text-bold" href="{{ route('roles.index') }}"> Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('roles.update',$role->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="exampleInputEmail1">Role Name</label>
                            <input type="text" class="form-control"  name="name" value="{{$role->name}}" required  placeholder="Role Name">
                        </div>
                        <div class="form-group">
                            <label class="text-bold text-uppercase">Assign Permissions</label>

                            @foreach($permission as $value)
                                <div class="custom-control custom-checkbox">
                                    <label>
                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }} class="name">
                                        {{ $value->name }}
                                    </label>
                                </div>
                                <br/>
                            @endforeach
                        </div>
                        <!-- /.card-body -->
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
