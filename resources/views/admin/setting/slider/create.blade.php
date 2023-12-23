@extends('admin.layout.layout')


@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header">
                        <h3 class="box-title text-uppercase text-bold">{{$page_title}}</h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <div class="float-right mt-1">
                                <a class="btn bg-fuchsia-active uppercase text-bold" href="{{ route('sliders.index') }}"> Back</a>
                            </div>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <!-- form start -->
                        {!! Form::open(['route'=>['sliders.store'],'method'=>'post','files' => true]) !!}
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="form-group">
                                        <label class="text-bold text-uppercase">Slider Title</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control"  name="title" value="{{old('title')}}" required placeholder="Slider Title">
                                            <div class="input-group-addon">
                                                <i class="fa fa-bolt"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-bold text-uppercase">Slider Description</label>
                                        <div class="input-group" style="width: 100%;">
                                            <textarea name="description" id="editor" rows="06" cols="100" ></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <img id='img-upload'/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-bold text-uppercase">Slider Image</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="image" id="imgInp" required placeholder="User Email">
                                            <div class="input-group-addon">
                                                <i class="fa fa-image"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-bold text-uppercase">Status</label>
                                        <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Active" data-off="Deactivate" data-width="100%" type="checkbox" name="status">
                                    </div>
                                    <button type="submit" class="btn btn-info btn-lg btn-block fa fa-send bold uppercase"> Slider Create</button>
                                </div>
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