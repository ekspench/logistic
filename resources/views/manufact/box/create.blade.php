@extends('layouts.adminmaster')

@section('styles')
    <!-- INTERNAl Summernote css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote.css') }}?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="{{ asset('assets/css/bd-wizard.css') }}">
    <link href="{{ asset('assets/plugins/sweet-alert/sweetalert.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
    <!-- INTERNAl dropzone css -->
    <link href="{{ asset('assets/plugins/dropzone/dropzone.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />

    <!-- INTERNAl bootstraptag css -->
    <link href="{{ asset('assets/plugins/taginput/bootstrap-tagsinput.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
    <style>
        .page-main {
            background-color: #191d43;
             !important;
        }
    </style>
@endsection

@section('content')
    <!--Page header-->

    <!--End Page header-->

    <!--Article Create-->
    <div class=" container" style=" height: 100%;">
        <div class="col-xl-12 col-lg-12 col-md-12 mt-8 p-4  ">

            <form class="forms-sample p-4  " id="form_cast" method="POST" action="{{ route('box.create') }}">
                @csrf

                <div id="wizard2" class="wizard2">
                    <h3 class="text-white">Reference de pièce</h3>
                    <section>
                        <h5 class="bd-wizard-step-title text-white">Étape 1</h5>
                        <h2 class="section-heading text-white">Choisissez la référence</h2>

                        <div>
                            <div class="purpose-radios-wrapper">
                                @foreach ($parts as $key => $part)
                                    <div class="purpose-radio">
                                        <input data-ref="{{ $part->reference }}" data-max-cast={{ $part->max_cast }}
                                            type="radio" value="{{ $part->id }}" name="part_id"
                                            id="{{ $part->id }}" class="purpose-radio-input"
                                            @if ($key == 0) required @endif>
                                        <label for="{{ $part->id }}" class="purpose-radio-label">
                                            <span class="label-text text-white " style="font-size:32px">
                                                {{ $part->reference }}</span>
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </section>

                    <h3 class="text-white">Numero de caisse</h3>
                    <section>
                        <h5 class="bd-wizard-step-title text-white">Étape 2</h5>
                        <h2 class="section-heading text-white">N° Caisse</h2>
                        <p class="text-white">Le numéro de caisse augmente automatiquement en fonction de la précédente. En
                            cas de besoin celui-ci peut être changé uniquement par le contrôleur qualité. Dans le cas ou le
                            numéro de caisse ne correspond pas et que le contrôleur qualité n’est pas présent merci de
                            mettre un mot et le numéro de caisse à ajuster.</p>
                        <div class="row px-4">
                            <div class="input-group mb-3">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon1"><i
                                        style="height: 116px;font-size: 64px" class="fa fa-lock"></i></button>
                                <input readonly  style="font-size: 64px" type="text" id="box_number" class="form-control"
                                    placeholder="" aria-label="Example text with button addon"
                                    aria-describedby="button-addon1" value="{{ count($box) }}" class="form-control"
                                    name="box_number">
                            </div>



                        </div>
                    </section>
                    <h3 class="text-white">Step 2 Title</h3>
                    <section>
                        <h5 class="bd-wizard-step-title text-white">Étape 3</h5>
                        <h2 class="section-heading text-white">Repère de coulée</h2>

                        <div class="row">


                            <div class="col-md-12">
                                <div class=" mb-0">
                                    <div class="">
                                        <div class="row">
                                            <div class="d-flex mb-4">
                                                <h5 class="ms-4">Réference pièce: <span class="partRefInfo"></span></h5>
                                                <h5 class="ms-4">N° Caisse: <span class="boxNumberInfo"></h5>
                                            </div>

                                            <div class="col-sm-8">
                                                <div class="form-inline">

                                                    {!! Form::input('text', null, null, [
                                                        'class' => 'form-control mb-2 mr-sm-2 mx-4 text-uppercase',
                                                        'placeholder' => 'Repère de collée',
                                                        'id' => 'i_cast_ref',
                                                    ]) !!}
                                                    {!! Form::input('number', null, null, [
                                                        'class' => 'form-control mb-2 mr-sm-2 mx-4',
                                                        'placeholder' => 'Quantité',
                                                        'id' => 'i_cast_qty',
                                                    ]) !!}
                                                    <button type="button" id="add_cast_btn"
                                                        class="btn btn-success btn-icon ml-2 mb-2">Ajouter</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="boxTable">
                                            <table id="boxTable" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="wp-30">Nom</th>
                                                        <th class="wp-20">Repère coulée</th>
                                                        <th class="wp-15">Quantité</th>
                                                        <th class="wp-15">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot class="mt-4">
                                                    <tr>
                                                        <th class="border-0" colspan="1"></th>
                                                        <th class="border-l-1">Total</th>
                                                        <th class="">
                                                            <div id="total_qty" class="w-60 text-center hm-30">00
                                                            </div>
                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>
                    <h3 class="text-white">Verification</h3>
                    <section>
                        <h5 class="bd-wizard-step-title text-white">Étape</h5>
                        <h2 class="section-heading mb-5 text-white">Prévisualisation</h2>
                        <h3>Réference pièce: <span class="partRefInfo"></span></h3>
                        <h3>N° Caisse: <span class="boxNumberInfo"></h3>
                        <table class="table table-hover mb-0 without-header " id="boxTableInfo">
                            <tbody>
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                        <h3 class="bg-white">TOTAL: <span id="totalInfo"></span></h3>
                    </section>
                </div>
            </form>

        </div>


    </div>
    <!--End Article Create-->
    <div class="modal fade" id="unlock_box_number" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mot de passe</h5>
                    <button class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">Veuillez entrer le mot de passe pour debloquer la saisie</h3>
                        <div class="row g-2 d-flex justify-content-center mt-4 ">
                            <div class="col-auto">
                                <label for="inputPassword2" class="visually-hidden">Password</label>
                                <input type="password" class="form-control" id="code" placeholder="Code">
                            </div>
                            <div class="col-auto">
                                <button type="submit" id="btnCheckPassword"
                                    class="btn btn-primary mb-3">Valider</button>
                            </div>
                        </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <!-- INTERNAL Vertical-scroll js-->
    <script src="{{ asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js') }}?v=<?php echo time(); ?>">
    </script>
    <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-validate/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/fr.js"></script>
    <script src="{{ asset('assets/js/box-create.js') }}"></script>

    <script>
              var user_name="<?php echo auth()->user()->name; ?>";
    </script>
    <!-- INTERNAL Index js-->
    <script src="{{ asset('assets/js/support/support-sidemenu.js') }}?v=<?php echo time(); ?>"></script>
    <script src="{{ asset('assets/js/select2.js') }}?v=<?php echo time(); ?>"></script>

    <!-- INTERNAL dropzone js-->
    <script src="{{ asset('assets/plugins/dropzone/dropzone.js') }}?v=<?php echo time(); ?>"></script>

    <!-- INTERNAL bootstraptag js-->
    <script src="{{ asset('assets/plugins/taginput/bootstrap-tagsinput.js') }}?v=<?php echo time(); ?>"></script>
    <script src="{{ asset('assets/plugins/jquery-mask/jquery.mask.js') }}?v=<?php echo time(); ?>"></script>

    <script>
        $('#i_cast_ref').mask('099.AAA');
        $('#button-addon1').on('click', function() {
            $('#unlock_box_number').modal('show');
        });
        $('#btnCheckPassword').on('click', function() {
            if ($("#code").val() != "scania") {
                swal({
                    title: `Code incorrect`,
                    text: "Le code que vous avez saisie est incorrect",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
            } else {
                $("#box_number").removeAttr('readonly');
				$('#unlock_box_number').modal('hide');
				$("#button-addon1 i").removeClass( "fa fa-lock" ).addClass( "fa fa-unlock-alt" );
            }
        });
    </script>
@endsection
