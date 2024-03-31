@extends('admin.layout.layout')
@push('css')
    <link rel="stylesheet" href="{{asset('/assets')}}/css/bootstrap-fileinput.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/assets')}}/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('/assets')}}/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
                            <a class="btn btn-primary uppercase text-bold" href="{{ route('gift.index') }}"> Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('gift.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <input type="text" class="form-control"  name="title" value="{{old('title')}}" required  placeholder="Title">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Asset</label>
                                    <select class="select2bs4" name="asset_type" required data-placeholder="Select a State" style="width: 100%;">
                                        <option value="">Choose One</option>
                                        @php
                                            $reflection = new ReflectionClass(\App\Enums\AssetTypeEnums::class);
                                            $assets = $reflection->getConstants();
                                        @endphp

                                        @foreach($assets as $name => $value)
                                            <option value="{{$value}}" {{old('asset_type') == $value ? 'selected' : ''}}>{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Status</label>
                                    <select class="select2bs4" name="status" required data-placeholder="Select a State" style="width: 100%;">
                                        <option value="">Choose One</option>
                                        @php
                                            $reflection = new ReflectionClass(\App\Enums\GiftStatusEnums::class);
                                            $giftStatus = $reflection->getConstants();
                                        @endphp
                                        @foreach($giftStatus as $name => $value)
                                            <option value="{{$value}}" {{old('status') == $value ? 'selected' : ''}}>{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Amount</label>
                                    <input type="text" class="form-control"  name="amount" value="{{old('amount')}}" required  placeholder="Gift Amount">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Gift Type</label>
                                    <select class="select2bs4" name="gift_type" required data-placeholder="Select a State" style="width: 100%;">
                                        <option value="">Choose One</option>
                                        @php
                                            $reflection = new ReflectionClass(\App\Enums\GiftTypeEnums::class);
                                            $giftTypes = $reflection->getConstants();
                                        @endphp
                                        @foreach($giftTypes as $name => $value)
                                            <option value="{{$value}}" {{old('gift_type') == $value ? 'selected' : ''}}>{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="text-uppercase text-bold">Gift Banner</label>
                                    <div class="input-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 215px; height: 215px; padding: 0px;" data-trigger="fileinput">

                                                <img style="width: 215px" src="" alt="Please Select Your Image......">
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
    <script src="{{asset('/assets')}}/select2/js/select2.full.min.js"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
        });

    </script>
@endpush
