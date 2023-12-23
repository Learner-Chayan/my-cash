@extends('admin.layout.layout')
@push('css')

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
                            <a href="{{route('permissions.index')}}" class="btn btn-primary float-right"> Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Permission Name</label>
                                <input type="text" class="form-control"  name="name" value="{{old('name')}}" required  placeholder="Permission Name">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="crud" id="check">
                                    <label for="customCheckbox1" class="custom-control-label" id="check">Check me out for ( *-create *-store *-edit *-update *-destroy )</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <strong>Assign Permission to Role:</strong>
                                <br />
                                @foreach ($roles as $value)
                                    <label>{{ Form::checkbox('role[]', $value->id, false, ['class' => 'name']) }}
                                        {{ $value->name }}</label>
                                    <br />
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
@push('js')

@endpush
