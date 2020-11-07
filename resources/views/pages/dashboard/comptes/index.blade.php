@extends('layout.app')
@section('title')
    Propriétaires
@endsection

@section('proprietaire-active')
    active
@endsection

@section('proprietaire-show')
    show
@endsection

@section('active_compte')
    active
@endsection
@section('content')
    <p class="mb-4">
        <a href="javascript:void(0)" class="btn btn-primary" id="btn_add"><i class="fa fa-plus-circle"></i> Nouveau militaire</a>
    </p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">LISTES DES COMPTES BANCAIRES DES PROPRIETAIRE</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped dt-responsive nowrap" id="compte_dataTable" width="100%">
                    <thead>
                    <tr>

                        <th>ID</th>
                        <th>NOM COMPTE</th>
                        <th>TYPE COMPTE</th>
                        <th>N.COMPTE</th>
                        <th>BANQUE</th>
                        <th>PROPIETAIRE</th>
                        <th>ENREGISTRE LE</th>
                        <th>ACTIONS</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_compte" tabindex="-1" role="dialog" aria-labelledby="addCompte" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCompte"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="compte_form">
                        @csrf
                        <input type="hidden" id="compte_id" name="compte_id">
                        <div class="row">
                            <div class="form-group col-lg-4 col-sm-12">
                                <label for="nom_compte">Nom Du Compte</label>
                                <input placeholder="Entrer Le Nom Du Compte" type="text" name="nom_compte" id="nom_compte" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-4 col-sm-12">
                                <label for="nom_compte">Nome De La Banque</label>
                                <input placeholder="Entrer Le Nom De La Banque" type="text" name="nom_banque" id="nom_banque" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-4 col-sm-12">
                                <label for="type_compte">Type De Compte</label>
                                <input placeholder="Entrer Le Type De Compte" type="text" name="type_compte" id="type_compte" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="numero_compte">Numero Du Compte</label>
                                <input placeholder="Entrer Le Numero Du Compte" type="text" name="numero_compte" id="numero_compte" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="proprietaire_id">Nom Du Propriétaire</label>
                                <select class="form-control" name="proprietaire_id" id="proprietaire_id" required>
                                    <option value="">Choisir Le Propriétaire De Ce Compte</option>
                                    @foreach(\App\Models\Proprietaire::all() as $proprio)
                                        <option value="{{$proprio->id}}">{{$proprio->civilite.' '.$proprio->nom.' '.$proprio->prenoms}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="reset"><i class="fa fa-close"></i>  Annuler</button>
                            <button class="btn btn-success" type="submit"><i class="fa fa-check-circle"></i>  <span id="btn_text"></span></button>
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
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#btn_add").click(function () {
               $("#add_compte").modal('show');
               $("#addCompte").text("AJout d'un nouveau compte");
               $("#btn_text").text("Sauvegarder maintenant")
                $("#compte_id").val('')
            });

            $("button[type='reset']").click(function () {
                $("#add_compte").modal('hide');
                $("#compte_id").val('')
            })

            $("#compte_dataTable").dataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'
                },
                ajax:{
                    url: '{{route('compte.home')}}',
                    type: 'GET'
                },
                columns:[
                    {data: 'id', name: 'id', 'visible': false},
                    {data: 'nom_compte', name: 'nom_compte'},
                    {data: 'type_compte', name: 'type_compte'},
                    {data: 'numero_compte', name: 'numero_compte'},
                    {data: 'nom_banque', name: 'nom_banque'},
                    {data: 'proprietaire', name: 'proprietaire'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [[0, 'desc']]
            })

            $('body').on('click', '#edit_compte', function () {
                let id = $(this).data('id');
                $.get('/dashboard/comptes/'+id, function (data) {
                    $("#compte_id").val(data.id)
                    $("#nom_compte").val(data.nom_compte)
                    $("#nom_banque").val(data.nom_banque)
                    $("#type_compte").val(data.type_compte)
                    $("#numero_compte").val(data.numero_compte)
                    $("#add_compte").modal('show');
                    $("#btn_text").text("Modifier maintenat");
                    $("#addCompte").text("Modification des information du compte");
                })
            });

            $('body').on('click','#delete_compte', function () {
                let id = $(this).data('id');
                if(confirm("Êtes-vous sûr de vouloir supprimer ce compte ?")){
                    $.get('/dashboard/comptes/'+id+'/delete', function (data) {
                        console.log(data)
                    })
                }
            });

            let form = $("#compte_form");
            if (form.length >0){
                form.validate();
                form.on('submit',function (e) {
                    e.preventDefault();
                    $("#btn_text").text('Envoie en cours...')
                    $.ajax({
                        data: new FormData(this),
                        url: '{{route('compte.store')}}',
                        type:'POST',
                        dataType: 'JSON',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            toastr.success(data, 'OPERATION REUSSIE');
                            form.get(0).reset();
                            $("#compte_id").val('');
                            $("#add_compte").modal('hide');
                            $("#btn_text").text("Sauvegader maintenant");
                            const CTable = $("#compte_dataTable").dataTable();
                            CTable.fnDraw(false);
                        },
                        error:function (data) {
                            $("#btn_text").text("Sauvegader maintenant");
                            console.log(data)
                            switch (data.status) {
                                case 422:
                                    toastr.error('Un ou Plusieurs champs ne sont pas correctement renseignés', 'ERREUR CHAMPS');
                                    break;
                                case 500:
                                    toastr.error("Erreur lors de connexion au serveur",'ERREUR SERVEUR');
                                    break;
                                default:
                                    toastr.info("Quelque s'est mal passée, veuillez rééssayer plus tard", "ERREUR INCONNUE")
                            }
                        }
                    })

                })
            }

        });
    </script>
@endsection
