@extends('layouts.adminmaster')

@section('styles')
    <!-- INTERNAL Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}?v=<?php echo time(); ?>"
        rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/buttonbootstrap.min.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />

    <!-- INTERNAL Sweet-Alert css -->
    <link href="{{ asset('assets/plugins/sweet-alert/sweetalert.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
@endsection
@section('content')
    <!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title"><span
                    class="font-weight-normal text-muted ms-2">Logistiques</span>
            </h4>
        </div>
    </div>
    <!--End Page header-->

    <!-- Employee List -->
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card ">
            <div class="card-header border-0 d-md-max-block">
                <h4 class="card-title  mb-md-max-2">Liste des caisses</h4>
                <div class="card-options  d-md-max-block">
                    @can('Add Box')
                        <a href="{{ url('manufact/box/create') }}" class="btn btn-success me-3  mb-md-max-2 mw-12"><i class="fa fa-paper-plane-o pe-lg-2"></i>Saisie</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive spruko-delete">
                    <table class="table table-vcenter text-nowrap table-bordered table-striped ticketdeleterow w-100"
                        id="boxlist">
                        <thead>
                            <tr>
                                <th class="text-center wp-5">{{ __('part_ref') }}</th>
                                <th class="text-center">{{ __('box_number') }}</th>
                                <th class="text-center">{{ __('quantity') }}</th>
                                <th class="text-center">{{ __('conforme') }}</th>
                                <th class="text-center">{{ __('non conforme') }}</th>
                                <th class="text-center">{{ __('status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Employee List -->
@endsection

@section('scripts')
    <!-- INTERNAL Data tables -->
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}?v=<?php echo time(); ?>"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}?v=<?php echo time(); ?>"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}?v=<?php echo time(); ?>"></script>
    <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}?v=<?php echo time(); ?>"></script>
    <script src="{{ asset('assets/plugins/datatable/datatablebutton.min.js') }}?v=<?php echo time(); ?>"></script>
    <script src="{{ asset('assets/plugins/datatable/buttonbootstrap.min.js') }}?v=<?php echo time(); ?>"></script>

    <!-- INTERNAL Sweet-Alert js-->
    <script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js') }}?v=<?php echo time(); ?>"></script>

    <script type="text/javascript">
        var SITEURL = '{{ url('') }}';
        (function($) {
            "use strict";

            // Csrf Field
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Datatable
            $('#boxlist').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('/manufact/box/get-list') }}"
                },
                columns: [		{ data: 'part_ref', name: 'part_ref', orderable: false, searchable: false, class:"text-center" },
                { data: 'box_number', name: 'box_number', class:"text-center" },
                { data: 'quantity', name: 'quantity', orderable: false, searchable: false, class:"text-center" },
                { data: 'quantity_conforme', name: 'conforme', orderable: false, searchable: false, class:"text-center" },
                { data: 'quantity_no_conforme', name: 'no_conforme', orderable: false, searchable: false, class:"text-center" },
                { data: 'status', name: 'status', orderable: false, searchable: false, class:"text-center" },
                { data: 'action', name: 'action',class:"text-right",orderable: false, searchable: false}
                ],
                order: [],
                responsive: true,
                drawCallback: function() {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll(
                        '[data-bs-toggle="tooltip"]'))
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    });

                    $('.form-select').select2({
                        minimumResultsForSearch: Infinity,
                        width: '100%'
                    });

                    $('#customCheckAll').prop('checked', false);

                    $('.checkall').on('click', function() {
                        if ($('.checkall:checked').length == $('.checkall').length) {
                            $('#customCheckAll').prop('checked', true);
                        } else {
                            $('#customCheckAll').prop('checked', false);
                        }
                    });
                },
            });

            // __Select2 js
            $('.form-select').select2({
                minimumResultsForSearch: -1
            });

            // __Check All checkbox
            $('#customCheckAll').on('click', function() {
                $('.checkall').prop('checked', this.checked);

            });

            // Check all js when if all selected check all
            $('.checkall').on('click', function() {
                if ($('.checkall:checked').length == $('.checkall').length) {
                    $('#customCheckAll').prop('checked', true);
                } else {
                    $('#customCheckAll').prop('checked', false);
                }
            });
            // Delete Button
            $('body').on('click', '#show-delete', function() {
                var _id = $(this).data("id");
                swal({
                        title: `{{ trans('langconvert.admindashboard.wanttocontinue') }}`,
                        text: "{{ trans('langconvert.admindashboard.eraserecordspermanently') }}",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "post",
                                url: SITEURL + "/admin/agent/" + _id,
                                success: function(data) {
                                    toastr.error(data.error);
                                    $('#row_id' + _id).remove();
                                },
                                error: function(data) {
                                    console.log('Error:', data);
                                }
                            });
                        }
                    });

            });

            // status switch
            $('body').on('click', '.tswitch', function() {
                var _id = $(this).data("id");
                var status = $(this).prop('checked') == true ? '1' : '0';
                $.ajax({
                    type: "post",
                    url: SITEURL + "/admin/agent/status/" + _id,
                    data: {
                        'status': status
                    },
                    success: function(data) {

                        toastr.success(data.success);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });

            //Mass Delete 
            $('body').on('click', '#massdelete', function() {
                var id = [];
                $('.checkall:checked').each(function() {
                    id.push($(this).val());
                });
                if (id.length > 0) {
                    swal({
                            title: `{{ trans('langconvert.admindashboard.wanttocontinue') }}`,
                            text: "{{ trans('langconvert.admindashboard.eraserecordspermanently') }}",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: "{{ url('admin/massuser/deleteall') }}",
                                    method: "post",
                                    data: {
                                        id: id
                                    },
                                    success: function(data) {

                                        //for client side
                                        $.each(id, function(index, value) {
                                            $('#row_id' + value).remove();
                                        });

                                        toastr.error(data.error);

                                    },
                                    error: function(data) {

                                    }
                                });
                            }
                        });
                } else {
                    toastr.error('{{ trans('langconvert.functions.checkboxselect') }}');
                }
            });
        })(jQuery);
    </script>
@endsection
