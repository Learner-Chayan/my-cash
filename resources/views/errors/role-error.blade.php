@extends('admin.layout.layout')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-danger">403</h2>

            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Something went wrong.</h3>

                <p>
                   You do not have access this page!
                </p>

            </div>
        </div>
        <!-- /.error-page -->

    </section>
    <!-- /.content -->
@endsection
