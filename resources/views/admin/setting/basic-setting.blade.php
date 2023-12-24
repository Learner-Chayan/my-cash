@extends('admin.layout.layout')
@push('css')
    <link rel="stylesheet" href="{{asset('/assets')}}/css/bootstrap-fileinput.css">
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
                            <a class="btn btn-primary uppercase text-bold" href="{{ route('dashboard') }}"> Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="basic-setting-tab" data-toggle="pill" href="#basic-setting" role="tab" aria-controls="basic-setting" aria-selected="true">Basic Setting</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="basic-logo-tab" data-toggle="pill" href="#basic-logo" role="tab" aria-controls="basic-logo" aria-selected="false">Basic Logo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="basic-favicon-tab" data-toggle="pill" href="#basic-favicon" role="tab" aria-controls="basic-favicon" aria-selected="false">Favicon</a>
                        </li>

                    </ul>
                    <div class="tab-content" id="custom-content-below-tabContent">
                        <div class="tab-pane fade active show" id="basic-setting" role="tabpanel" aria-labelledby="basic-setting-tab">
                            <form action="{{ route('get-basic-update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Website Title</label>
                                                <input type="text" class="form-control" name="title" value="{{$basic->title}}"  placeholder="Website Title">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Website Email</label>
                                                <input type="email" class="form-control" name="email" value="{{$basic->email}}"  placeholder="Website Email">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Website Currency</label>
                                                <input type="text" class="form-control" name="currency" value="{{$basic->currency}}"  placeholder="Website Currency">
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Website Phone</label>
                                                <input type="text" class="form-control" name="phone" value="{{$basic->phone}}"  placeholder="Website Phone">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Website Address</label>
                                                <input type="text" class="form-control" name="address" value="{{$basic->address}}"  placeholder="Website Address">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="basic-logo" role="tabpanel" aria-labelledby="basic-logo-tab">
                            <form action="{{ route('get-basic-update') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group" style="margin-left: 333px">
                                    <label class="text-uppercase text-bold">Logo</label>
                                    <div class="input-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 215px; height: 215px; padding: 0px;" data-trigger="fileinput">
                                                <img style="width: 215px" src="{{asset('public/logo.png') }}" alt="Please Select Your Image......">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 215px; max-height: 215px"></div>
                                            <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select Logo</span>
                                                    <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="logo" accept="image/*">
                                                </span>
                                                <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                        </form>

                        </div>
                        <div class="tab-pane fade" id="basic-favicon" role="tabpanel" aria-labelledby="basic-favicon-tab">
                            <form action="{{ route('get-basic-update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group" style="margin-left: 333px">
                                <label class="text-uppercase text-bold">Favicon Image</label>
                                <div class="input-group">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 215px; height: 215px; padding: 0px;" data-trigger="fileinput">
                                            <img style="width: 215px" src="{{asset('public/favicon.png') }}" alt="Please Select Your Image......">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 215px; max-height: 215px"></div>
                                        <div>
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select Favicon Image</span>
                                                <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                <input type="file" name="favicon" accept="image/*">
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- /.card -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@push('js')
    <script src="{{asset('/assets')}}/js/bootstrap-fileinput.js"></script>
@endpush
