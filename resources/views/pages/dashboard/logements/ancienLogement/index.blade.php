@extends('layout.app')
@section('title')
    Anciens Logements
@endsection

@section('l_ancien-active')
    active
@endsection

@section('logement-show')
    show
@endsection

@section('content')
    <style>
        #ancienL_form .form-control.error{
            width: 100% !important;
        }
    </style>
    <p class="mb-4">
        <a href="javascript:void(0)"
           class="btn btn-primary"
           id="btn_add">
            <i class="fa fa-plus-circle"></i>
            Signaler ancien logement
        </a>
    </p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">LISTES DES LOGEMENTS ANTERIEURS</h6>
        </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped dt-responsive nowrap" id="ancienLogement_dataTable" width="100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>MILITAIRE</th>
                    <th>EMPLACEMENT</th>
                    <th>DEBUT DU BAIL</th>
                    <th>FIN DU BAIL</th>
                    <th>ENREGISTRE LE</th>
                    <th>ACTIONS</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    </div>

    <div class="modal fade" id="ancienL_modal" tabindex="-1" role="dialog" aria-labelledby="ancienLModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ancienLModal"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ancienL_form">
                        @csrf
                        <input type="hidden" name="ancien_logement_id" id="ancien_logement_id">
                       <div class="row">
                           <div class="fom-group mb-3 col-lg-6 col-sm-12">
                               <label for="militaire">Militaite Concerné</label>
                               <select name="militaire" id="militaire" class="form-control" required>
                                   <option value="">Choisir Le Militaire Concerné par cette Opération</option>
                                   @foreach(\App\Models\Militaire::all() as $militaire)
                                       <option value="{{$militaire->id}}">{{$militaire->nom.' '.$militaire->prenom}}</option>
                                   @endforeach
                               </select>
                           </div>
                           <div class="fom-group mb-3 col-lg-6 col-sm-12">
                               <label for="emplacement">Emplacement Du Logement</label>
                               <select name="emplacement" id="emplacement" class="form-control" required>
                                   <option value="">Préciser L'Emplacement Du Logement</option>
                                   @foreach(\App\Models\Emplacement::all() as $empl)
                                       <option value="{{$empl->id}}">{{$empl->ville.' '.$empl->commune.' - '.$empl->quartier}}</option>
                                   @endforeach
                               </select>
                           </div>
                               <div class="col-lg-6"></div>
                               <div class="col-lg-6">
                                   <div class="form-check">
                                       <input class="form-check-input" type="checkbox" value="" id="date_fin_tody">
                                       <label class="form-check-label" for="date_fin_tody">
                                           Ajourd'hui
                                       </label>
                                   </div>
                               </div>
                           <div class="fom-group mb-3 col-lg-6 col-sm-12">
                               <label for="date_debut">Date De Début Du Bail</label>
                               <input type="date" class="form-control" id="date_debut" name="date_debut" required>
                           </div>
                           <div class="fom-group mb-3 col-lg-6 col-sm-12">
                               <label for="date_fin">Date De Fin Du Bail</label>
                               <input type="date" class="form-control" id="date_fin" name="date_fin" required>
                           </div>

                           <div class="form-group mb-3">
                               <button class="btn btn-danger">Annuler</button>
                               <button class="btn btn-success"> <i class="fa fa-check-circle"></i> <span id="btn_text"></span></button>
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
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("#btn_add").click(function () {
                $("#ancienL_modal").modal('show');
                $("#ancienL_form").get(0).reset();
                $("#ancien_logement_id").val('');
                $("#btn_text").text("Sauvegarder maitenant");
            });

            $("button[type='reset']").click(function () {
                $("#ancienL_form").get(0).reset();
                $("#ancien_logement_id").val('');
                $("#ancienL_modal").modal('hide');
            });

            const body = $('body');

            body.on('click','#edit_ancienL', function () {
                const id = $(this).data('id');
                $.get('/dashboard/anciens_logements/'+id, function (data) {
                    console.log(data);
                    $("#ancien_logement_id").val(data.id);
                    $("#militaire").val(data.militaire_id);
                    $("#emplacement").val(data.emplacement_id);
                    $("#date_debut").val(data.date_debut);
                    $("#date_fin").val(data.date_fin);
                    $("#ancienL_modal").modal('show');
                })
            });

            body.on('click','#delete_ancienL',function () {
                if(confirm("Êtes-vous sûr de vouloir supprimer cet ancien logement ?")){
                    const id = $(this).data('id');
                    $.get('/dashboard/anciens_logements/'+id+'/delete',function (data) {
                        const AlTable = $("#ancienLogement_dataTable").dataTable();
                        AlTable.fnDraw(false);
                        toastr.success(data, "SUPPRESSION REUSSIE")
                    })
                }
            });

            $("#ancienLogement_dataTable").dataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                language:{
                    url:'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'
                },
                ajax:{
                    type: 'GET',
                    url: '{{route('ancienL.home')}}'
                },
                columns:[
                    {data: 'id', name: 'id', 'visible': false},
                    {data: 'militaire', name: 'militaire'},
                    {data: 'emplacement', name: 'emplacement'},
                    {data: 'date_debut', name: 'date_debut'},
                    {data: 'date_fin', name: 'date_fin'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order: [[0, 'DESC']]
            });

            const form = $("#ancienL_form");
            let btn_text =  $("#btn_text");
            form.validate();
            if (form.length > 0){
                form.on('submit', function (e) {
                    e.preventDefault();
                    btn_text.text('Envoie en cours...');
                    $.ajax({
                        type: 'POST',
                        url: '{{route('ancienL.store')}}',
                        data: new FormData(this),
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            btn_text.text('Sauvegarder maintenant');
                            form.get(0).reset();
                            $("#ancien_logement_id").val('');
                            $("#ancienL_modal").modal('hide');
                            const ancienLTable = $("#ancienLogement_dataTable").dataTable();
                            ancienLTable.fnDraw(false);
                            toastr.success(data, "OPERATION REUSSIE");
                        },
                        error: function (data) {
                            console.log(data);
                            btn_text.text('Sauvegarder maintenant');
                            switch (data.status) {
                                case 422:
                                    toastr.error("Un ou Plusieurs Champs ne sont pas correctement renseignés", "ERREUR CHAMPS")
                                    break;
                                case 500:
                                    toastr.warning("Erreur rencontrée lors de la communication avec le serveur", "ERREUR SERVEUR")
                                    break;
                                default:
                                    toastr.error("Erreur inconnue", "ERREUR INCONNUE")
                            }
                        }
                    })
                })
            }
        });
    </script>
@endsection
