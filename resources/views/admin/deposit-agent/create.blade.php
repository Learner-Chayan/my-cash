@extends('admin.layout.layout')
@push('css')
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
                            <a class="btn btn-primary uppercase text-bold" href="{{ route('deposit-agent.index') }}"> Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('deposit-agent.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name <code>*</code></label>
                                    <input type="text" class="form-control"  name="name" value="{{old('name')}}" required  placeholder="Account Holder">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Number <code>*</code></label>
                                    <input type="text" class="form-control"  name="number" value="{{old('number')}}" required  placeholder="Account Number">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Payment Option <code>*</code></label>
                                    <select name="payment_method" id="payment_method" class="select2bs4 form-control" required>
                                        <option value="">Choose One</option>
                                        <option value="rocket">Rocket</option>
                                        <option value="nagad">Nagad</option>
                                        <option value="bkash">Bkash</option>
                                        <option value="dbbl">DBBL</option>
                                        <option value="sureCash">Sure Cash</option>
                                        <option value="agraniBankLimited">Agrani Bank Limited</option>
                                        <option value="bangladeshDevelopmentBank">Bangladesh Development Bank</option>
                                        <option value="basicBankLimited">BASIC Bank Limited</option>
                                        <option value="janataBankLimited">Janata Bank Limited</option>
                                        <option value="rupaliBankLimited">Rupali Bank Limited</option>
                                        <option value="sonaliBankLimited">Sonali Bank Limited</option>
                                    </select>
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
