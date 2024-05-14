@extends('admin.layout.layout')
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/assets')}}/css/bootstrap-fileinput.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('/assets')}}/summernote/summernote-bs4.min.css">
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
                            <a class="btn btn-primary uppercase text-bold" href="{{ route('home-notification.index') }}"> Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('home-notification.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title <code>*</code></label>
                                    <input type="text" class="form-control"  name="title" value="{{old('title')}}" required  placeholder="Title">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Description <code>*</code></label>
                                    <textarea class="form-control" id="summernote" name="description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="text-uppercase text-bold">Image</label>
                                    <div class="input-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 180px; height: 180px; padding: 0px;" data-trigger="fileinput">

                                                <img style="width: 180px" src="" alt="Please Select Your Image......">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 180px; max-height: 180px"></div>
                                            <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select Image</span>
                                                    <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="image" accept="image/*">
                                                </span>
                                                <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                            </div>
                                        </div>
                                    </div>
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
    <script src="{{asset('/assets')}}/js/bootstrap-fileinput.js"></script>
    <!-- Summernote -->
    <script src="{{asset('/assets')}}/summernote/summernote-bs4.min.js"></script>
    <script>
        // $(function () {
        //     // Summernote
        //     $('#summernote').summernote()

        //     // CodeMirror
        //     CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        //         mode: "htmlmixed",
        //         theme: "monokai"
        //     });
        // })
    </script>
@endpush
