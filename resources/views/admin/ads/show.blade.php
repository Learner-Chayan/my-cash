@extends('admin.layout.layout')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- /.card -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{$page_title}}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $adminStatusNames = [
                                \App\Enums\PermissionStatusEnums::APPROVED => 'Approved',
                                \App\Enums\PermissionStatusEnums::CHECKING => 'Pending',
                            ];
                            $assetNames = [
                                \App\Enums\AssetTypeEnums::GOLD->value => 'Gold',
                                \App\Enums\AssetTypeEnums::BDT->value => 'BDT',
                            ];
                            $adTypeNames = [
                                \App\Enums\AdsTypeEnums::SELL => 'Sell',
                                \App\Enums\AdsTypeEnums::BUY => 'Buy',
                            ];
                            $priceNames = [
                                \App\Enums\PriceTypeEnums::FIXED => 'Fixed',
                                \App\Enums\PriceTypeEnums::FLOATING => 'Floating',
                            ];

                        @endphp
                        <!-- /.col -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <i>Admin Status: {{ $adminStatusNames[$ad->permission_status] ?? 'Unknown' }}</i>
                                                <small class="float-right">Post Date: {{\Carbon\Carbon::parse($ad->date)->format('d M, Y')}}</small>
                                            </h4>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col">
                                            Post By
                                            <address>
                                                <strong>{{$ad->user->name}}</strong><br>
                                                Phone: {{$ad->user->phone}}<br>
                                                Email: {{$ad->user->email}}
                                            </address>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4 invoice-col">
                                            Asset Details
                                            <address>
                                                <strong>Asset: {{ $assetNames[$ad->asset_type] ?? 'Unknown'  }}</strong><br>
                                                Unit Price: {{$ad->unit_price}}<br>
                                                Highest Price: {{$ad->highest_price}}<br>
                                                Sell Price: {{$ad->sell_price}}<br>
                                            </address>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4 invoice-col">
                                            <b>Ad Number #{{$ad->ads_unique_num}}</b><br>
                                            <b>Ad Status:</b> {{$adminStatusNames[$ad->permission_status] ?? 'Unknown'  }}<br>
                                            <b>Ad Type:</b> {{ $adTypeNames[$ad->ad_type] ?? 'Unknown' }}<br>
                                            <b>Price Type:</b> {{ $priceNames[$ad->price_type] ?? 'Unknown' }}<br>
                                            <b>Total Amount:</b> {{ $ad->total_amount }}<br>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <div class="row no-print">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-success float-right delete_button" data-toggle="modal" data-target="#DelModal" data-id="{{ $ad->id }}"><i class="far fa-check-circle"></i> Admin Approval</button>
                                        </div>
                                    </div>
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>

    <div class="modal fade" id="DelModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Change status!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to change Status ?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <form action="{{route('ads.destroy',0)}}" method="post" id="deleteForm">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <input type="hidden" name="id" id="delete_id" class="delete_id" value="0">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary deleteButton float-right">OK!</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $(document).on("click", '.delete_button', function (e) {
                var id = $(this).data('id');
                var url = '{{ route("ads.destroy",":id") }}';
                url = url.replace(':id',id);
                $("#deleteForm").attr("action",url);
                $("#delete_id").val(id);
            });
        });
    </script>
@endpush
