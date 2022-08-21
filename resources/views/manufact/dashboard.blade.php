@extends('layouts.adminmaster')

@section('styles')
    <!-- INTERNAL Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/buttonbootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- INTERNAL Sweet-Alert css -->
    <link href="{{ asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title"><span
                    class="font-weight-normal text-muted ms-2">{{ trans('langconvert.menu.dashboard') }}</span></h4>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-flex breadcrumb-res">
                    <div class="header-datepicker me-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="feather feather-calendar"></i>
                            </div><input class="form-control fc-datepicker pb-0 pt-0"
                                value="{{ now(Auth::user()->timezone)->format(setting('date_format')) }}" type="text"
                                disabled>
                        </div>
                    </div>
                    <div class="header-datepicker picker2 me-3">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="feather feather-clock"></i>
                            </div><!-- input-group-text -->
                            <input id="tpBasic " type="text"
                                placeholder="{{ \Carbon\Carbon::now(Auth::user()->timezone)->format(setting('time_format')) }}"
                                class="form-control input-small pb-0 pt-0" disabled>
                        </div>
                    </div><!-- wd-150 -->
                </div>
            </div>
        </div>
    </div>
    <!--End Page header-->

    <!--Dashboard List-->
    <div class="row">

        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-12">
                    <div class="card">
                        <a href="" class="admintickets"></a>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-start"><span class="fs-14 font-weight-semibold">Rebuts</span>
                                        <h3 class="mb-0 mt-1 mb-2">{{ count($castes_scrap) }}</h3>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-primary my-auto  float-end"> <i class="las la-ticket-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12">
                    <div class="card">
                        <a href="" class="admintickets"></a>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-start"><span class="fs-14 font-weight-semibold">Reparation</span>
                                        <h3 class="mb-0 mt-1 mb-2">{{ $castes_repair->count() }}</h3>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-primary my-auto  float-end"> <i class="las la-ticket-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12">
                    <div class="card">
                        <a href="" class="admintickets"></a>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-start"><span class="fs-14 font-weight-semibold">Validée</span>
                                        <h3 class="mb-0 mt-1 mb-2">{{ $castes_validate->count() }}</h3>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-primary my-auto  float-end"> <i class="las la-ticket-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12">
                    <div class="card">
                        <a href="" class="admintickets"></a>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-start"><span class="fs-14 font-weight-semibold">En attente</span>
                                        <h3 class="mb-0 mt-1 mb-2">{{ $castes_pending->count() }}</h3>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-primary my-auto  float-end"> <i class="las la-ticket-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div style="max-width:720px" id="chart"></div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card mb-0">
                        <div class="card-header border-0">
                            <h4 class="card-title">Dernier pièce coulée</h4>
                        </div>
                        <div class="card-body">

                            <div id="reportrange"
                                style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;max-width: 350px;">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                            <div class="table-responsive delete-button">
                                <table
                                    class="table table-vcenter text-nowrap table-bordered table-striped w-100 ticketdeleterow"
                                    id="listCast">
                                    <thead>
                                        <tr>
                                            <th>Reference</th>
                                            <th>N° Caisse</th>
                                            <th>Marque de coulée</th>
                                            <th>Status</th>
                                            <th>Remplacement</th>
                                            <th>Date</th>



                                        </tr>
                                    </thead>
                                    <tbody id="refresh">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Dashboard List-->
@endsection
@section('scripts')
    <!-- INTERNAL Vertical-scroll js-->
    <script src="{{ asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js') }}"></script>
    <!-- INTERNAL Apexchart js-->
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.js') }}?v=<?php echo time(); ?>"></script>

    <!-- INTERNAL Data tables -->
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/datatablebutton.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/buttonbootstrap.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/fr.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- INTERNAL Index js-->
    <script src="{{ asset('assets/js/support/support-sidemenu.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>

    <!-- INTERNAL Sweet-Alert js-->
    <script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>

    <script type="text/javascript">
        "use strict";

        (function($) {

            // Variables
            var SITEURL = '{{ url('') }}';

            @if (Auth::user()->usetting != null)
                @if (Auth::user()->usetting->ticket_refresh == 1)

                    // Auto Refresh Datatable js
                    setInterval(function() {
                        $('#listCast').DataTable().ajax.reload();

                    }, 30000);
                @endif
            @endif

            // csrf field
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            moment.locale('fr');
            // Datatable
            var minDate = new Date();
            var maxDate = new Date();
            var start = moment();
            var end = moment().add("1", "days");


            var table = $('#listCast').DataTable({
                dom: '<"row"<"col-md-12 col-lg-1"l><"col-md-12 col-lg-4"B><"col-md-12 col-lg-7"f>r>tip',


                processing: true,
                serverSide: true,
                ajax: {
                    url: "/manufact/cast/get-list",
                    "type": "POST",
                    "datatype": "json",
                    data: function(d) {
                        d.min = start.format('YYYY-MM-DD'),
                            d.max = end.format('YYYY-MM-DD')
                    }
                },
                columns: [

                    {
                        data: 'reference',
                        name: 'reference',
                        class: 'text-center'
                    },
                    {
                        data: 'number',
                        name: 'number',
                        class: 'text-center'
                    },
                    {
                        data: 'mark',
                        name: 'mark',
                        class: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        class: 'text-center'
                    },
                    {
                        data: 'replace',
                        name: 'replace',
                        class: 'text-center'
                    },
                    {
                        data: 'date',
                        name: 'date',
                        class: 'text-center'
                    },
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

            function cb(s, e) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                start = s;
                end = e;
                table.draw();
            }
            // checkbox checkall
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Ajourd\'hui': [moment(), moment()],
                    'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Les 7 derniers jours': [moment().subtract(6, 'days'), moment()],
                    'Les 30 derniers jours': [moment().subtract(29, 'days'), moment()],
                    'Ce mois-ci': [moment().startOf('month'), moment().endOf('month')],
                    'Le mois dernier': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month')
                        .endOf('month')
                    ]
                }
            }, cb);

            cb(start, end);
            // Assigned Submit button
            $('body').on('submit', '#assigned_form', function(e) {
                e.preventDefault();
                var actionType = $('#btnsave').val();
                var fewSeconds = 2;
                $('#btnsave').html('Sending..');
                $('#btnsave').prop('disabled', true);
                setTimeout(function() {
                    $('#btnsave').prop('disabled', false);
                }, fewSeconds * 1000);
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: SITEURL + "/admin/assigned/create",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: (data) => {

                        $('#AssignError').html('');
                        $('#assigned_form').trigger("reset");
                        $('#addassigned').modal('hide');
                        $('#btnsave').html('Save Changes');
                        var oTable = $('#listCast').dataTable();
                        oTable.fnDraw(false);
                        toastr.success(data.success);
                    },
                    error: function(data) {
                        $('#AssignError').html('');
                        $('#AssignError').html(data.responseJSON.errors.assigned_user_id);
                        $('#btnsave').html('Save Changes');
                    }
                });
            });

            // Remove the assigned from the ticket
            $('body').on('click', '#btnremove', function() {
                var asid = $(this).data("id");
                swal({
                        title: `{{ trans('langconvert.admindashboard.agentremove') }}`,
                        text: "{{ trans('langconvert.admindashboard.agentremove1') }}",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {

                            $.ajax({
                                type: "get",
                                url: SITEURL + "/admin/assigned/update/" + asid,
                                success: function(data) {
                                    var oTable = $('#listCast').dataTable();
                                    oTable.fnDraw(false);
                                    toastr.error(data.error);

                                },
                                error: function(data) {
                                    console.log('Error:', data);
                                }
                            });

                        }
                    });
            });



            $('#customCheckAll').on('click', function() {
                $('.checkall').prop('checked', this.checked);
            });





            var options = {
                series: [76, 67, 61, 90],
                chart: {
                    height: 390,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        offsetY: 0,
                        startAngle: 0,
                        endAngle: 270,
                        hollow: {
                            margin: 5,
                            size: '30%',
                            background: 'transparent',
                            image: undefined,
                        },
                        dataLabels: {
                            name: {
                                show: true,
                            },
                            value: {
                                show: true,
                            }
                        }
                    }
                },
                colors: ['#26fd18', '#20261f', '#182a5b', '#4e570b'],
                labels: ['Conformité', 'Rebut', 'Contrôle RX/UX', 'Réparation'],
                legend: {
                    show: true,
                    floating: true,
                    fontSize: '16px',
                    position: 'left',
                    offsetX: 160,
                    offsetY: 15,
                    labels: {
                        useSeriesColors: true,
                    },
                    markers: {
                        size: 0
                    },
                    formatter: function(seriesName, opts) {
                        return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
                    },
                    itemMargin: {
                        vertical: 3
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            show: true
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render()

        })(jQuery);
    </script>
@endsection

@section('modal')
    @include('admin.modalpopup.assignmodal')
@endsection
