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
                    <form action="{{ route('gift.update', $gift->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <input type="text" class="form-control"  name="title" value="{{$gift->title}}" required  placeholder="Title">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Asset</label>
                                    <select class="select2bs4" name="asset_type" required data-placeholder="Select a State" style="width: 100%;">
                                        <option value="">Choose One</option>
                                        @foreach(\App\Enums\AssetTypeEnums::cases() as $asset)
                                            <option value="{{$asset->value}}" {{$gift->asset_type == $asset->value ? 'selected' : ''}}>{{$asset->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Status</label>
                                    <select class="select2bs4" name="status" required data-placeholder="Select a State" style="width: 100%;">
                                        <option value="">Choose One</option>
                                        @foreach(\App\Enums\GiftStatusEnums::cases() as $giftStatus)
                                            <option value="{{$giftStatus->value}}" {{$gift->status == $giftStatus->value ? 'selected' : ''}}>{{$giftStatus->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Amount</label>
                                    <input type="text" class="form-control"  name="amount" value="{{$gift->amount}}" required  placeholder="Gift Amount">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Gift Type</label>
                                    <select class="select2bs4" name="gift_type" required data-placeholder="Select a State" style="width: 100%;">
                                        <option value="">Choose One</option>
                                        @foreach(\App\Enums\GiftTypeEnums::cases() as $giftType)
                                            <option value="{{$giftType->value}}" {{$gift->gift_type == $giftType->value ? 'selected' : ''}}>{{$giftType->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="text-uppercase text-bold">Gift Banner</label>
                                    <div class="input-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 215px; height: 100px; padding: 0px;" data-trigger="fileinput">
                                                @php
                                                    $giftService = new \App\Services\GiftService();
                                                    $image = $giftService->getImage($gift->id)
                                                @endphp
                                                <img style="width: 215px" src="{{$image}}" alt="Please Select Your Image......">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 215px; max-height: 100px"></div>
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
                        <!-- /.card-body -->
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
