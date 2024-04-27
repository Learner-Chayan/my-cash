@extends('admin.layout.layout')
@push('css')
    <style>
        .mag {
            width:100%;
            margin: 0 auto;
            float: none;
        }

        .mag img {
            height: 200px;
            max-width: 100%;
        }



        .magnify {
            position: relative;
            cursor: none
        }

        .magnify-large {
            position: absolute;
            display: none;
            width: 175px;
            height: 175px;

            -webkit-box-shadow: 0 0 0 7px rgba(255, 255, 255, 0.85), 0 0 7px 7px rgba(0, 0, 0, 0.25), inset 0 0 40px 2px rgba(0, 0, 0, 0.25);
            -moz-box-shadow: 0 0 0 7px rgba(255, 255, 255, 0.85), 0 0 7px 7px rgba(0, 0, 0, 0.25), inset 0 0 40px 2px rgba(0, 0, 0, 0.25);
            box-shadow: 0 0 0 7px rgba(255, 255, 255, 0.85), 0 0 7px 7px rgba(0, 0, 0, 0.25), inset 0 0 40px 2px rgba(0, 0, 0, 0.25);

            -webkit-border-radius: 100%;
            -moz-border-radius: 100%;
            border-radius: 100%
        }
    </style>
@endpush
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
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mag"> Front Side<br>
                                                <img data-toggle="magnify" src="{{$frontSide}}" alt="">
                                            </div>
                                        </div>
                                         <div class="col-md-4">
                                            <div class="mag"> Back Side<br>
                                                <img data-toggle="magnify" src="{{$backSide}}" alt="">
                                            </div>
                                        </div>
                                         <div class="col-md-4">
                                            <div class="mag"> Selfi<br>
                                                <img data-toggle="magnify" src="{{$selfi}}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.card-body -->

                            </div>
                            <!-- /.card -->
                            @if($frontSide && $backSide && $selfi != 0)
                            <div class="col-md-12">
                                <button title="{{$customer->is_authenticated > 0 ? 'Remove Verification' : 'Approve Verification'}}" class="btn  btn-danger bold uppercase delete_button" data-toggle="modal" data-target="#DelModal" data-id="{{ $customer->id }}">
                                    {{$customer->is_authenticated > 0 ? 'Remove Verification' : 'Approve Verification'}}
                                </button>
                            </div>
                            @endif
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
                    <h4 class="modal-title">Verification</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want {{$customer->is_authenticated > 0 ? 'decline verification' : 'approve verification'}}  ?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <form action="{{route('request-update',0)}}" method="get" id="deleteForm">
                        {!! csrf_field() !!}
                        <input type="hidden" name="customer_id" id="delete_id" class="delete_id" value="0">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger deleteButton float-right">{{$customer->is_authenticated > 0 ? 'Remove Verification' : 'Approve Verification'}}!</button>
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
                var url = '{{ route("request-update",":id") }}';
                url = url.replace(':id',id);
                $("#deleteForm").attr("action",url);
                $("#delete_id").val(id);
            });
        });
    </script>
    <script>
        !function ($) {

            "use strict"; // jshint ;_;


            /* MAGNIFY PUBLIC CLASS DEFINITION
             * =============================== */

            var Magnify = function (element, options) {
                this.init('magnify', element, options)
            }

            Magnify.prototype = {

                constructor: Magnify

                , init: function (type, element, options) {
                    var event = 'mousemove'
                        , eventOut = 'mouseleave';

                    this.type = type
                    this.$element = $(element)
                    this.options = this.getOptions(options)
                    this.nativeWidth = 0
                    this.nativeHeight = 0

                    this.$element.wrap('<div class="magnify" \>');
                    this.$element.parent('.magnify').append('<div class="magnify-large" \>');
                    this.$element.siblings(".magnify-large").css("background","url('" + this.$element.attr("src") + "') no-repeat");

                    this.$element.parent('.magnify').on(event + '.' + this.type, $.proxy(this.check, this));
                    this.$element.parent('.magnify').on(eventOut + '.' + this.type, $.proxy(this.check, this));
                }

                , getOptions: function (options) {
                    options = $.extend({}, $.fn[this.type].defaults, options, this.$element.data())

                    if (options.delay && typeof options.delay == 'number') {
                        options.delay = {
                            show: options.delay
                            , hide: options.delay
                        }
                    }

                    return options
                }

                , check: function (e) {
                    var container = $(e.currentTarget);
                    var self = container.children('img');
                    var mag = container.children(".magnify-large");

                    // Get the native dimensions of the image
                    if(!this.nativeWidth && !this.nativeHeight) {
                        var image = new Image();
                        image.src = self.attr("src");

                        this.nativeWidth = image.width;
                        this.nativeHeight = image.height;

                    } else {

                        var magnifyOffset = container.offset();
                        var mx = e.pageX - magnifyOffset.left;
                        var my = e.pageY - magnifyOffset.top;

                        if (mx < container.width() && my < container.height() && mx > 0 && my > 0) {
                            mag.fadeIn(100);
                        } else {
                            mag.fadeOut(100);
                        }

                        if(mag.is(":visible"))
                        {
                            var rx = Math.round(mx/container.width()*this.nativeWidth - mag.width()/2)*-1;
                            var ry = Math.round(my/container.height()*this.nativeHeight - mag.height()/2)*-1;
                            var bgp = rx + "px " + ry + "px";

                            var px = mx - mag.width()/2;
                            var py = my - mag.height()/2;

                            mag.css({left: px, top: py, backgroundPosition: bgp});
                        }
                    }

                }
            }


            /* MAGNIFY PLUGIN DEFINITION
             * ========================= */

            $.fn.magnify = function ( option ) {
                return this.each(function () {
                    var $this = $(this)
                        , data = $this.data('magnify')
                        , options = typeof option == 'object' && option
                    if (!data) $this.data('tooltip', (data = new Magnify(this, options)))
                    if (typeof option == 'string') data[option]()
                })
            }

            $.fn.magnify.Constructor = Magnify

            $.fn.magnify.defaults = {
                delay: 0
            }


            /* MAGNIFY DATA-API
             * ================ */

            $(window).on('load', function () {
                $('[data-toggle="magnify"]').each(function () {
                    var $mag = $(this);
                    $mag.magnify()
                })
            })

        } ( window.jQuery );
    </script>
@endpush
