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
                    <form action="{{ route('deposit-agent.update', $agent->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name <code>*</code></label>
                                    <input type="text" class="form-control"  name="name" value="{{$agent->name}}" required  placeholder="Account Holder">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Number <code>*</code></label>
                                    <input type="text" class="form-control"  name="number" value="{{$agent->number}}" required  placeholder="Account Number">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Payment Option <code>*</code></label>
                                    <select name="payment_method" id="payment_method" class="select2bs4 form-control" required>
                                        <option value="">Choose One</option>
                                        <option value="rocket" {{$agent->payment_method == 'rocket' ? 'selected' : '' }}>Rocket</option>
                                        <option value="nagad" {{$agent->payment_method == 'nagad' ? 'selected' : '' }}>Nagad</option>
                                        <option value="bkash" {{$agent->payment_method == 'bkash' ? 'selected' : '' }}>Bkash</option>
                                        <option value="dbbl" {{$agent->payment_method == 'dbbl' ? 'selected' : '' }}>DBBL</option>
                                        <option value="sureCash" {{$agent->payment_method == 'sureCash' ? 'selected' : '' }}>Sure Cash</option>
                                        <option value="agraniBankLimited" {{$agent->payment_method == 'agraniBankLimited' ? 'selected' : '' }}>Agrani Bank Limited</option>
                                        <option value="bangladeshDevelopmentBank" {{$agent->payment_metod == 'bangladeshDevelopmentBank' ? 'selected' : '' }}>Bangladesh Development Bank</option>
                                        <option value="basicBankLimited" {{$agent->payment_metod == 'basicBankLimited' ? 'selected' : '' }}>BASIC Bank Limited</option>
                                        <option value="janataBankLimited" {{$agent->payment_metod == 'janataBankLimited' ? 'selected' : '' }}>Janata Bank Limited</option>
                                        <option value="rupaliBankLimited" {{$agent->payment_metod == 'rupaliBankLimited' ? 'selected' : '' }}>Rupali Bank Limited</option>
                                        <option value="sonaliBankLimited" {{$agent->payment_metod == 'sonaliBankLimited' ? 'selected' : '' }}>Sonali Bank Limited</option>
                                    </select>
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
