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
                        {!! Form::open(['route'=>['get-copy-right-update'],'method'=>'POST','files'=>'true' ]) !!}
                        <div class="box-body">
                            <div class="row">
                               <div class="col-md-8 col-md-offset-2">
                                   <div class="form-group">
                                       <div class="input-group" style="width: 100%;">
                                           <textarea id="editor" style="height: 100px; " name="copy" rows="1" cols="22">{!! $basic->copy !!}</textarea>
                                           <button type="submit" class="btn btn-info btn-lg btn-block"> Copy Right Update</button>
                                       </div>
                                   </div>

                               </div>
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