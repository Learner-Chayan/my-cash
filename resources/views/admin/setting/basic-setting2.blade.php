@extends('admin.layout.layout')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header">
                        <h3 class="box-title text-uppercase text-bold">{{$page_title}}</h3>
                        <!-- tools box -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <!-- form start -->
                        {!! Form::open(['route'=>['get-basic-update'],'method'=>'POST','files'=>'true' ]) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Custom Tabs -->
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active text-uppercase text-bold"><a href="#tab_1" data-toggle="tab">Basic Setting</a></li>
                                            <li><a href="#tab_2 " class="text-uppercase text-bold" data-toggle="tab">Basic Logo</a></li>
                                            <li><a href="#tab_3 " class="text-uppercase text-bold" data-toggle="tab">Basic Favicon Icon</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="text-uppercase text-bold">Website Title</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" name="title" value="{{$basic->title}}"  placeholder="Website Title">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-weibo"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="text-uppercase text-bold">Website Email</label>
                                                                <div class="input-group">
                                                                    <input type="email" class="form-control" name="email" value="{{$basic->email}}"  placeholder="Website Email">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-envelope"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="text-uppercase text-bold">Website Phone</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" name="phone" value="{{$basic->phone}}"  placeholder="Website Phone">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-phone"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="text-uppercase text-bold">Website Tags</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" name="meta_tag" value="{!! $basic->meta_tag !!}"  placeholder="Website Tags">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-tags"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="text-uppercase text-bold">Website Description</label>
                                                                <div class="input-group" style="width: 759px;">
                                                                    <textarea id="editor"  name="description" rows="1" cols="76" placeholder="Website Description">{!! $basic->description !!}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="text-uppercase text-bold">Website Address</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" name="address" value="{{$basic->address}}"  placeholder="Website Address">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-location-arrow"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="tab_2">
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
                                            </div>
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="tab_3">
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
                                            </div>
                                            <!-- /.tab-pane -->
                                            <button type="submit" class="btn btn-info btn-lg btn-block fa fa-send text-uppercase text-bold"> Basic Update</button>
                                        </div>
                                        <!-- /.tab-content -->
                                    </div>
                                    <!-- nav-tabs-custom -->
                                </div>
                                <!-- /.col -->
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->
    </section>
@endsection