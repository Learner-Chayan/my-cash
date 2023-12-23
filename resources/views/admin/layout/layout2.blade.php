<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <title> {{$page_title}} | {{$site_title}}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/favicon.png') }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('/assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/assets/admin/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('/assets/admin/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- jvectormap -->    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/assets/admin/dist/css/AdminLTE.min.css')}}">

    <link rel="stylesheet" href="{{asset('/assets/admin/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/admin/css/editor.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/admin/css/file.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/admin/dist/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/admin/dist/css/toggle.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/admin/dist/css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/admin/advanceTable/datatable.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/admin/advanceTable/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/admin/advanceTable/datatable.button.min.css')}}">
    <link href="{{ asset('/assets/admin/dist/css/bootstrap-fileinput.css') }}" rel="stylesheet">


    <link href="{{asset('/assets/admin/dist/css/social.css')}}" rel="stylesheet" />

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    @stack('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

@include('admin.partial.topbar')
<!-- Left side column. contains the logo and sidebar -->
@include('admin.partial.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            @if($errors->any())
                @foreach ($errors->all() as $error)

                    <div class="alert alert-icon-left alert-warning alert-dismissible mb-1" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        {!!  $error !!}
                    </div>
                @endforeach
            @endif
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <strong>{!! $basic->copy !!}</strong>
    </footer>
    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="{{asset('/assets/admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('/assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/assets/admin/dist/js/adminlte.min.js')}}"></script>
<script src="{{ asset('/assets/admin/dist/js/bootstrap-fileinput.js') }}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{asset('/assets/admin/dist/js/toggle.min.js')}}"></script>
<script src="{{asset('/assets/admin/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('/assets/admin/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/admin/js/editor.min.js')}}"></script>

<script src="{{asset('/assets/admin/advanceTable/datatable.min.js')}}"></script>
<script src="{{asset('/assets/admin/advanceTable/datatable.button.min.js')}}"></script>
<script src="{{asset('/assets/admin/advanceTable/pdf-maker.min.js')}}"></script>
<script src="{{asset('/assets/admin/advanceTable/zip.min.js')}}"></script>
<script src="{{asset('/assets/admin/advanceTable/buttons.html5.min.js')}}"></script>
<script src="{{asset('/assets/admin/advanceTable/pdf.vs_font.min.js')}}"></script>

<script>

    $(document).ready(function() {
        $('#editor').summernote({
            tabsize: 2,
            minHeight:100,
            codemirror: { // codemirror options
                theme: 'monokai'
            },
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example1').DataTable( {
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
            buttons: [
                {
                    extend: 'pageLength',
                },

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: '{{$basic->title}} Data Export',
                    exportOptions: {
                        columns: [ 0, 1, 3, 4, 5 ]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: '{{$basic->title}} Data Export',
                    exportOptions: {
                        columns: [ 0, 1, 3, 4, 5 ]
                    }
                },

                // 'pageLength',
                // 'excelHtml5',
                // 'pdfHtml5'
            ]
        } );

    } );

    $(document).ready( function() {
        $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function(){
            readURL(this);
        });
    });
</script>

<script>

    $(function () {
        $('.select2').select2()
    });
    $('#datepicker').datepicker({
        autoclose: true
    });

</script>

@if (Session::has('success'))
    <script>
        Swal.fire({
            position: 'top-center',
            type: 'success',
            title: '{{Session::get('success')}}',
            showConfirmButton: false,
            timer: 2000
        })
    </script>
@endif

@if (Session::has('error'))
    <script>
        Swal.fire({
            position: 'center',
            type: 'error',
            title: '{{Session::get('error')}}',
            showConfirmButton: false,
            timer: 2000
        })
    </script>
@endif

<!-- Page script -->
@stack('js')

</body>
</html>
