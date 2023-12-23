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
                <div class="card-body">
                    {!! Form::open(['route'=>['permissions.update',$permission->id],'method'=>'put','files'=>'true' ]) !!}
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
                                    <label>{{ Form::checkbox('role[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                        {{ $value->name }}</label>
                                    <br/>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.card -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

