@extends('admin.layout.layout')
@push('css')
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('/assets')}}/summernote/summernote-bs4.min.css">
@endpush
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{$page_title}}</h3>
                        <div class="pull-right box-tools">
                            <div class="float-right mt-1">
                                <a class="btn btn-primary uppercase text-bold" href="{{ route('dashboard') }}"> Back</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {!! Form::open(['route'=>['get-privacy-update'],'method'=>'POST','files'=>'true' ]) !!}
                        <div class="box-body">
                            <textarea id="summernote" name="privacy">{!! $basic->about !!}</textarea>

                            <div class="form-group">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-info btn-block"> Privacy Update</button>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
            <!-- /.col-->
        </div>
    </section>
@endsection
@push('js')
    <!-- Summernote -->
    <script src="{{asset('/assets')}}/summernote/summernote-bs4.min.js"></script>
    <script>
        $(function () {
            // Summernote
            $('#summernote').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
@endpush
