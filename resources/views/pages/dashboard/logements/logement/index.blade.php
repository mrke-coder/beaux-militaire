@extends('layout.app')
@section('title')
    Logements
@endsection

@section('l_actuel-active')
    active
@endsection

@section('logement-show')
    show
@endsection

@section('content')
    <p class="mb-4">
        <a href="javascript:void(0)"
           class="btn btn-primary"
           id="btn_add">
            <i class="fa fa-plus-circle"></i>
            Nouveau Logement
        </a>
    </p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">LISTES DES LOGEMENTS</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped dt-responsive nowrap" id="logement_dataTable" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>N. PIECES</th>
                        <th>EMPLACEMENT</th>
                        <th>TYPE DE LOGEMENT</th>
                        <th>PROPRIETAIRE</th>
                        <th>MILITAIRE</th>
                        <th>ENREGISTRE LE</th>
                        <th>ACTIONS</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="logement_modal" tabindex="-1" role="dialog" aria-labelledby="logementModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logementModal"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="logement_form">
                        @csrf
                        <input type="hidden" id="logement_id" name="logement_id">
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                                <label for="numero_lot">Numéro Du Lot</label>
                                <input type="text" class="form-control" id="numero_lot" name="numero_lot" placeholder="Entrer Le Numéro Du Lot" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                                <label for="numero_ilot">Numéro Du Ilot</label>
                                <input type="text" class="form-control" id="numero_ilot" name="numero_ilot" placeholder="Entrer Le Numéro Du Ilot" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                                <label for="nombre_piece">Nombre De Pièces</label>
                                <input type="number" class="form-control" id="nombre_piece" name="nombre_piece" placeholder="Entrer Le Nombre De Pièces" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                                <label for="emplacement_id">Selectionner un emplacement</label>
                                <select class="form-control" id="emplacement_id" name="emplacement_id" required>
                                    <option value="">Choisir un emplacement</option>
                                    @foreach(\App\Models\Emplacement::all() as $value)
                                        <option value="{{$value->id}}">{{$value->ville.' '.$value->commune.' '.$value->quartier}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                                <label for="type_logement_id">Selectionner Le Type De Logement</label>
                                <select class="form-control" id="type_logement_id" name="type_logement_id" required>
                                    <option value="">Choisir le type de logement</option>
                                    @foreach(\App\Models\TypeLogement::all() as $value)
                                        <option value="{{$value->id}}">{{$value->description}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-12 col-md-6 mb-3">
                                <label for="proprietaire_id">Selectionner Le Propriétaire Du Logement</label>
                                <select class="form-control" id="proprietaire_id" name="proprietaire_id" required>
                                    <option value="">Choisir le propriétaire du logement</option>
                                    @foreach(\App\Models\Proprietaire::all() as $value)
                                        <option value="{{$value->id}}">{{$value->nom.' '.$value->prenoms}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-12 col-md-12 mb-3">
                                <label for="militaire_id">Selectionner Le Militaire concerné</label>
                                <select class="form-control" id="militaire_id" name="militaire_id" required>
                                    <option value="">Choisir le Militaire</option>
                                    @foreach(\App\Models\Militaire::all() as $value)
                                        <option value="{{$value->id}}">{{$value->nom.' '.$value->prenom}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <button type="reset" class="btn btn-danger"><i class="fa fa-close"></i> Annuler</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> <span id="btn_text"></span></button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function () {
            $("#btn_add").click(function(){
                $("#logement_modal").modal('show');
                $("#logementModal").text("AJout d'un nouveau logement");
                $("#logement_id").val("");
                $("#btn_text").text("Sauvegarder maintenant");
                $("#logement_form").get(0).reset();
            });

            $("button[type='reset']").click(function () {
                $("#logement_modal").modal('hide');
                $("#logement_id").val("");
                $("#logement_form").get(0).reset();
            });

            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $("meta[name='crsf-token']").attr('content')
                }
            });

            $("#logement_dataTable").dataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                language:{
                    url:'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'
                },
                ajax:{
                    type:'GET',
                    url: '{{route('logement.home')}}'
                },
                columns:[
                    {data: 'id', name: 'id', 'visible': false},
                    {data: 'nombre_piece', name: 'nombre_piece'},
                    {data: 'emplacement', name: 'emplacement'},
                    {data: 'type_logement', name: 'type_logement'},
                    {data: 'proprietaire', name: 'proprietaire'},
                    {data: 'militaire', name: 'militaire'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable:false},
                ],
                order:[[0, 'desc']]
            });

            const body = $('body');
            body.on('click', '#edit_logement', function () {
                const id = $(this).data('id');
                $.get('/dashboard/logements/'+id, function (data) {
                    console.log(data);
                    $("#logement_id").val(data.id);
                    $("#numero_lot").val(data.numero_lot);
                    $("#numero_ilot").val(data.numero_ilot);
                    $("#nombre_piece").val(data.nombre_piece);
                    $("#militaire_id").val(data.militaire_id);
                    $("#emplacement_id").val(data.emplacement_id);
                    $("#proprietaire_id").val(data.proprietaire_id);
                    $("#type_logement_id").val(data.type_logement_id);
                    $("#logement_modal").modal('show');
                    $("#btn_text").text("Sauvegarder maintenant");
                })
            });

            body.on('click','#delete_logement', function () {
                if (confirm("Êtes-vous sûr de vouloir supprimer ce logement")){
                    const id_ = $(this).data('id');
                    $.get('/dashboard/logements/'+id_+'/delete', function (data) {
                        console.log(data);
                        toastr.success("Suppression effectuée avec succès","SUPPRESSION REUSSIE");
                        const LTable = $("#logement_dataTable").dataTable();
                        LTable.fnDraw(false);
                    });
                }
            });

            const form = $("#logement_form");
            form.validate();
            if (form.length > 0){
                form.on('submit', function (e) {
                    e.preventDefault();
                    $("#btn_text").text("Envoie en cours...");

                    $.ajax({
                        url:'{{route('logement.store')}}',
                        type: 'POST',
                        data: new FormData(this),
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            $("#btn_text").text("Sauvegarder maintenant");
                            console.log(data);
                            $("#logement_form").get(0).reset();
                            $("#logement_id").val('');
                            $("#logement_modal").modal("hide");
                            const LTable = $("#logement_dataTable").dataTable();
                            LTable.fnDraw(false);
                            toastr(data,"OPERATION REUSSIE")
                        },
                        error: function (data) {
                            $("#btn_text").text("Sauvegarder maintenant");
                            switch (data.status) {
                                case 422:
                                   toastr.error("Un ou Plusieurs champ de ce formulaire sont/est réquis.", "ERREUR CHAMPS")
                                   break;
                                case 500 :
                                    toastr.warning("Erreur au niveau du serveur a été signalée, Veuillez rééssayer ulterieurement","ERREUR SERVEUR")
                                    break;
                                default:
                                    toastr.error("Erreur inconnue, rééssayer, en cas de persistence signaler le developpeur", "ERREUR INCONNUE")
                            }
                        }
                    })
                })
            }


        })
    </script>
@endsection
