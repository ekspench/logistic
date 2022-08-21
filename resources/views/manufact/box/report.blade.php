@extends('layouts.adminmaster')

@section('content')
    <!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title"><span
                    class="font-weight-normal text-muted ms-2">{{ trans('langconvert.admindashboard.customer') }}</span>
            </h4>
        </div>
    </div>
    <!--End Page header-->

    <!-- Customer Edit -->
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card ">
            <div class="card-header border-0">
                <h4 class="card-title">Synthèse</h4>
                <div class="card-options mt-sm-max-2">
                </div>
            </div>
            <div class="card-body">
                <div class="row row-cols-4">
                    <div class="col"><Button class="btn btn-primary">Synthèse journalier</Button></div>
                </div>
            </div>
            <div>

            </div>

        </div>
    </div>
    <!-- End Customer Edit -->
@endsection

@section('scripts')
    <!-- INTERNAL select2 js-->
    <script src="{{ asset('assets/js/select2.js') }}"></script>
@endsection
