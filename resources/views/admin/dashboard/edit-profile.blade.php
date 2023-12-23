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
                   
                    <form action="{{ route('update-profile') }}" method="post" enctype="multipart/form-data"  >
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-uppercase text-bold">Your Image</label>
                                    <div class="input-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 215px; height: 215px; padding: 0px;" data-trigger="fileinput">
                                             
                                            <img style="width: 215px" src="{{ $image }}" alt="Please Select Your Image......">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 215px; max-height: 215px"></div>
                                            <div>
                                                        <span class="btn btn-info btn-file">
                                                            <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select Your Image</span>
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
                        <div class="col-md-8">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-uppercase text-bold">Your Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="name" value="{{$user->name}}"  placeholder="Your Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-uppercase text-bold">Your Email</label>
                                    <div class="input-group">
                                        <input type="email" class="form-control" name="email" value="{{$user->email}}" placeholder="Your Email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-uppercase text-bold">Your Phone</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="phone" value="{{$user->phone}}" placeholder="Your Phone">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                    </div>
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
@endpush
