@extends('admin.layout.layout')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- /.card -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{$page_title}}</h3>
                    <div class="pull-right box-tools">
                        <div class="float-right mt-1">
                            <a href="{{route('permissions.index')}}" class="btn btn-primary float-right"> Back</a>
                        </div>
                    </div>
                </div>
                <di class="card-body">
                    <form action="{{route('permissions.update',$permission->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Permission Name</label>
                                    <input type="text" class="form-control"  name="name" value="{{$permission->name}}" required  placeholder="Permission Name">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <strong>Update Assign Role:</strong>
                                    <br/>
                                    @foreach($roles as $value)
                                        <label>
                                            <input type="checkbox" name="role[]" value="{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }} class="name">
                                            {{ $value->name }}
                                        </label>
                                        <br/>
                                    @endforeach

                                </div>
                            </div>
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

