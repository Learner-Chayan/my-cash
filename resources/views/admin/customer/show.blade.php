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
                        <div class="col-md-3">

                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="{{ $image }}" alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center text-capitalize">{{$customer->name}}</h3>
                                    @if(!empty($customer->getRoleNames()))
                                        @foreach($customer->getRoleNames() as $v)
                                            <p class="text-muted text-center text-capitalize">{{$v}}</p>
                                        @endforeach
                                    @endif

{{--                                    <ul class="list-group list-group-unbordered mb-3">--}}
{{--                                        @foreach(\App\Models\Account::where('user_id',$customer->id) as $account)--}}
{{--                                            <li class="list-group-item">--}}
{{--                                                <b>{{$account->asset_type}}</b> <a class="float-right">{{$account->balance}}</a>--}}
{{--                                            </li>--}}
{{--                                        @endforeach--}}

{{--                                    </ul>--}}
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <!-- About Me Box -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Contact Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <strong><i class="fas fa-phone mr-1"></i> Phone</strong>

                                    <p class="text-muted">
                                        {{$customer->phone}}
                                    </p>

                                    <hr>

                                    <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                                    <p class="text-muted">{{$customer->email}}</p>

                                    <hr>

                                    <strong><i class="fas fa-id-badge mr-1"></i> Pay ID</strong>
                                    <p class="text-muted">{{$customer->pay_id}}</p>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">P2P</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Order List</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">

                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="timeline">

                                        </div>
                                        <!-- /.tab-pane -->

                                        <div class="tab-pane" id="settings">

                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
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
@endsection
@push('js')

@endpush
