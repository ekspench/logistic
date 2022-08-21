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
                <h4 class="card-title">BOX #{{ $box->ref }}</h4>
                <div class="card-options mt-sm-max-2">

                    @if ($box->is_valid)
                        <h3 href="#" class="badge badge-success mb-1 p-2">Validée
                        @else
                            <h3 href="#" class="badge badge-warning mb-1 p-2">En attente de validation par
                                controleur
                            </h3>
                    @endif


                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-start items-center">
                    <div class="d-flex me-4">
                        <div>Réference pièce: </div>
                        <div class="ms-1 fw-bold">{{ $box->part->reference }} </div>
                    </div>
                    <div class="d-flex me-4">
                        <div>Numero de caisse: </div>
                        <div class="ms-1 fw-bold">{{ $box->number }} </div>
                    </div>
                    <div class="d-flex me-4">
                        <div>Company:</div>
                        <div class="ms-1 fw-bold">SCANIA</div>
                    </div>

                </div>

                <form method="post" action="/manufact/box/update/{{ $box->id }}">
                    @csrf
                    <table id="boxTable"
                        class="table table-vcenter text-nowrap table-bordered table-striped ticketdeleterow w-100">
                        <thead>
                            <tr>
                                <th class="wp-10 text-center">Nom</th>
                                <th style="width: 2%" class=" text-center">N°</th>
                                <th class="text-center">Repère coulée</th>
                                <th class=" text-center">Poiçon</th>
                                <th class="text-center">Poinçon usiner</th>
                                <th class="text-center">Conforme</th>
                                <th class=" text-center">Rebut</th>
                                <th class="text-center">Réparation</th>
                                <th class="text-center">Contrôle RX</th>
                                <th class="text-center">Contrôle US</th>
                                <th style="width: 10%" class=" text-center">Remplacement</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($box->castes as $key => $cast)
                                @if ($box->is_valid)
                                    <tr>
                                        <input value="{{ $cast->id }}" type="hidden"
                                            name="castes[{{ $key }}][id]" />
                                        <td>{{$box->machinist->name}}</td>
                                        <td class="text-center">{{ $cast->number }}</td>
                                        <td class="text-center text-uppercase">{{ $cast->mark }}</td>

                                        <td class="text-center">{{$cast->hallmark}}</td>
                                        <td class="text-center">{{$cast->hallmark_machinist}}</td>
                                        <td class="text-center">
                                            @if ($cast->status === 'validated')
                                                <i class="fa fa-check text-success font-weight-bold"></i>
                                            @endif

                                        </td>
                                        <td class="text-center">
                                            @if ($cast->status === 'scrap')
                                                <i class="fa fa-check text-warning font-weight-bold"></i>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if ($cast->status === 'repair')
                                                <i class="fa fa-check text-warning font-weight-bold"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($cast->status === 'ux')
                                                <i class="fa fa-check text-warning font-weight-bold "></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($cast->status === 'ur')
                                                <i class="fa fa-check text-warning font-weight-bold"></i>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            {{ $cast->mark_replace }}
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <input value="{{ $cast->id }}" type="hidden"
                                            name="castes[{{ $key }}][id]" />
                                        <td>{{$box->machinist->name}}</td>
                                        <td class="text-center">{{ $cast->number }}</td>
                                        <td class="text-center text-uppercase">{{ $cast->mark }}</td>

                                        <td class="text-center"> @can('Control Box')
                                                <input type="text"  style="max-width: 100px" class="form-control mx-auto" name="castes[{{ $key }}][hallmark]" />
                                            @endcan
                                        </td>
                                        <td class="text-center">
                                            @can('Control Box')
                                                <input type="text"  style="max-width: 100px" class="form-control mx-auto" name="castes[{{ $key }}][hallmark_machinist]"/>
                                            @endcan
                                        </td>
                                        <td class="text-center">
                                            @can('Control Box')
                                                <div class="form-check">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="radio" name="castes[{{ $key }}][status]"
                                                            class="form-check-input radio-status" key="{{ $key }}"
                                                            value="validated" checked="">
                                                        <span class="form-check-label">&nbsp;
                                                        </span>
                                                    </label>
                                                </div>
                                            @endcan


                                        </td>
                                        <td class="text-center">
                                            @can('Control Box')
                                                <div class="form-check">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="radio" class="form-check-input  radio-status"
                                                            key="{{ $key }}" value="scrap"
                                                            name="castes[{{ $key }}][status]">
                                                        <span class="form-check-label">&nbsp;
                                                        </span>
                                                    </label>
                                                </div>
                                            @endcan
                                        </td>

                                        <td class="text-center">
                                            @can('Control Box')
                                                <div class="form-check">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="radio" class="form-check-input radio-status"
                                                            key="{{ $key }}" value="repair"
                                                            name="castes[{{ $key }}][status]">
                                                        <span class="form-check-label ">&nbsp;
                                                        </span>
                                                    </label>
                                                </div>
                                            @endcan


                                        </td>
                                        <td class="text-center">
                                            @can('Control Box')
                                                <div class="form-check">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="radio" class="form-check-input  radio-status"
                                                            key="{{ $key }}" value="ux"
                                                            name="castes[{{ $key }}][status]">
                                                        <span class="form-check-label">&nbsp;
                                                        </span>
                                                    </label>
                                                </div>
                                            @endcan
                                        </td>
                                        <td class="text-center">
                                            @can('Control Box')
                                                <div class="form-check">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="radio" disabled=""
                                                            class="form-check-input radio-status" key="{{ $key }}"
                                                            value="rx" name="castes[{{ $key }}][status]">
                                                        <span class="form-check-label ">&nbsp;
                                                        </span>
                                                    </label>
                                                </div>
                                            @endcan
                                        </td>

                                        <td class="text-center">
                                            @can('Control Box')
                                                <input type="text" name="castes[{{ $key }}][mark_replace]"
                                                    class="form-control" id="mark_replace{{ $key }}" disabled=""
                                                    placeholder="mark coulée">
                                            @endcan
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot class="mt-4">
                            <tr>

                                <th class="border-l-1 text-center" colspan="5">Total
                                </th>
                                <th class="text-center">
                                    {{ $box->castes_by_status('validated')->count() }}
                                </th>
                                <th class="text-center">
                                    {{ $box->castes_by_status('scrap')->count() }}</th>
                                <th class="text-center">
                                    {{ $box->castes_by_status('repair')->count() }}</th>
                                <th class="text-center">
                                    {{ $box->castes_by_status('rx')->count() }}</th>
                                <th class="text-center">
                                    {{ $box->castes_by_status('ux')->count() }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    @can('Control Box')
                        @if (!$box->is_valid)
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </div>
                        @endif
                    @endcan

                </form>
            </div>
            <div>
                <div class="float-end p-4">
                    @if (!$box->is_valid)
                        @can('Add Box')
                            <a href="/manufact/box/pdf/machinist-control/{{ $box->id }}" target="blank"
                                class="btn btn-primary">Fiche de controle</a>
                        @endcan
                    @else
                        @can('Control Box')
                            <div class="pt-4 text-right">
                                <a href="/manufact/box/pdf/label/{{ $box->id }}" target="blank"
                                    class="btn btn-primary">Imprimer label</a>
                            </div>
                        @endcan
                    @endif


                </div>
            </div>

        </div>
    </div>
    <!-- End Customer Edit -->

@endsection

@section('scripts')
    <!-- INTERNAL select2 js-->
    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <script>
        $('button[data-toggle=modal]').click(function() {
            $("#modal_cast_id").val($(this).data("cast-id"));
            $("#form_modal").attr("action", "/box/action/refuse-cast/" + $(this).data("box-id"));
        });
        $(".radio-status").on("change", function() {
            let key = $(this).attr('key');
            if ($(this).val() == 'validated') {
                $("#mark_replace" + key).attr("disabled", "disabled");
            } else {
                $("#mark_replace" + key).removeAttr("disabled");
            }

        });
    </script>
@endsection
