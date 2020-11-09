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

@section('active_pListe')
    active
@endsection

@section('content')
    @if($message = session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-close"></i> {{$message}}.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <p class="mb-4">
        <a href="javascript:void(0)"
           class="btn btn-primary"
           id="btn_add">
            <i class="fa fa-plus-circle"></i>
            Nouveau Propriétaire
        </a>
    </p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">LISTES DES PROPRIETAIRES</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped dt-responsive nowrap" id="proprietaire_dataTable" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>PHOTO</th>
                        <th>NOM</th>
                        <th>PRENOM</th>
                        <th>CONTACT</th>
                        <th>ENREGISTRE LE</th>
                        <th>ACTIONS</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_prioprietaire" tabindex="-1" role="dialog" aria-labelledby="addPrioprietaire" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPrioprietaire"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="proprietaire_form" autocomplete="off">
                        @csrf
                        <input type="hidden" id="proprietaire_id" name="proprietaire_id">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="photo">Choisir une photo pour le propriétaire</label>
                                    <input type="file" class="form-control" id="photo" name="photo">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Civilité du Propriétaire <span class="required">*</span></label><br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" value="M/Mr" id="civilite" name="civilite" class="custom-control-input" required checked>
                                        <label class="custom-control-label" for="civilite">Monsieur</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" value="Mme/Mlle" id="civilite1" name="civilite" class="custom-control-input" required>
                                        <label class="custom-control-label" for="civilite1">Madame</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="nom">Nom Du Propriétaire <span class="requis">*</span></label>
                                    <input type="text" name="nom" class="form-control" id="nom" required placeholder="Entrer Nom Du Propriétaire">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="prenom">Prénoms Du Propriétaire <span class="requis">*</span></label>
                                    <input type="text" name="prenom" class="form-control" id="prenom" required placeholder="Entrer Prénom Du Propriétaire">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="email">Adresse E-mail Du Propriétaire </label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Entrer Adresse E-mail Du Propriétaire">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="contact">Contact Téléphoniques Du Propriétaire </label>
                                    <input type="tel" name="contact" class="form-control" id="contact" required placeholder="Entrer Contacts Téléphoniques Du Propriétaire">
                                </div>
                            </div>
                            <div class="form-group">
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

            $("#btn_add").click(function () {
                $("#add_prioprietaire").modal('show')
                $("#proprietaire_id").val('')
                $("#proprietaire_form").get(0).reset();
                $("#btn_text").text("Sauvegarder maintenant")
            });

            $("button[type='reset']").click(function(){
               $("#add_prioprietaire").modal('hide');
               $("#proprietaire_id").val('');
            });

            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $("#proprietaire_dataTable").dataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'
                },
                ajax: {
                    url: '{{route('proprio.home')}}',
                    type: 'GET'
                },
                columns:[
                    {data: 'id', name: 'id', 'visible': false},
                    {data: 'photo', name: 'photo'},
                    {data: 'civilite', name: 'civilite', 'visible': false},
                    {data: 'nom', name: 'prenoms'},
                    {data: 'contact', name: 'contact'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order: [[0, 'desc']]
            });

            $('body').on('click','#edit_proprietaire', function () {
                let id_proprio = $(this).data('id');
                $.get('/dashboard/proprietaires/'+id_proprio, function (data) {
                    console.log(data);
                    $("#btn_text").text('Modifier maintenant');
                    $("#proprietaire_id").val(data.id);
                    $("#nom").val(data.nom);
                    $("#prenom").val(data.prenoms);
                    $("#email").val(data.email)
                    $("#contact").val(data.contact)
                    $("#add_prioprietaire").modal('show');
                })
            });

            $('body').on('click','#delete_proprietaire', function () {
                let id = $(this).data('id');
                if(confirm("Êtes-vous sûr de vouloir supprimer ce propriétaire")){
                    $.get('/dashboard/proprietaires/'+id+'/delete', function (data) {
                        const PTable = $("#proprietaire_dataTable").dataTable();
                        PTable.fnDraw(false);
                        toastr.success(data, "SUPPRESSION REUSSIE");
                    });
                }
            });

            let form = $("#proprietaire_form");
            if(form.length > 0){
                form.validate();
                form.on('submit', function (e) {
                    e.preventDefault();
                    $("#btn_text").text('Envoie en cours...');
                    $.ajax({
                        data: new FormData(this),
                        url: '{{route('proprio.store')}}',
                        type: 'POST',
                        dataType: 'JSON',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            console.log(data);
                            $("#btn_text").text("Enregistrement en cours");
                            toastr.success(data);
                            form.get(0).reset();
                            $('#proprietaire_id').val('');
                            $("#add_prioprietaire").modal('hide');
                            const PTable = $("#proprietaire_dataTable").dataTable();
                            PTable.fnDraw(false);
                        },
                        error: function (data) {
                            console.log(data)
                            $("#btn_text").text("Enregistrement en cours")
                            switch (data.status) {
                                case 422:
                                    toastr.error('Un ou Plusieurs champs ne sont pas correctement remplis.','ERREUR CHAMPS')
                                    break;
                                case 500:
                                    toastr.warning('Erreur survenue lors de la communication avec le serveur', 'Erreur SERVEUR');
                                    break;
                                default:
                                    toastr.error("Une erreur non repertoriée rencontrée", 'ERREUR INCONNUE')
                            }
                        }
                    })
                })
            }
        })
    </script>
@endsection
