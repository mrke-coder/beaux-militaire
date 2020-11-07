@extends('layout.app')
@section('title')
    Emplacements
@endsection
@section('emplacement-active')
    active
@endsection

@section('content')
    <p class="mb-4">
        <a href="javascript:void(0)"
           class="btn btn-primary"
           id="btn_add">
            <i class="fa fa-plus-circle"></i>
            Nouvel emplacement
        </a>
    </p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">LISTES DES EMPLACEMENTS ENREGISTRES</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped dt-responsive nowrap" id="emplacement_dataTable" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>VILLE</th>
                        <th>COMMUNE</th>
                        <th>QUARTIER</th>
                        <th>ENREGISTRE LE</th>
                        <th>ACTIONS</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_emplacement" tabindex="-1" role="dialog" aria-labelledby="addEmplacement" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmplacement"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_emplacement" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="emplacement_id" id="emplacement_id"/>
                        <div class="form-group mb-3">
                            <label for="ville">Ville</label>
                            <input type="text" name="ville" id="ville" class="form-control" placeholder="Entrer La Ville" required/>
                        </div>
                        <div class="form-group">
                            <label for="commune">Commune</label>
                            <input type="text" name="commune" id="commune" class="form-control" placeholder="Entrer La Commune" required/>
                        </div>
                        <div class="form-group">
                            <label for="quartier">Quartier</label>
                            <input type="text" name="quartier" id="quartier" class="form-control" placeholder="Entrer Le Quartier" required>
                        </div>
                        <div class="form-group">
                            <button type="reset" class="btn btn-danger"><i class="fa fa-close"></i> Annuler</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> <span id="btn_text"></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function(){
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });
            $("#btn_add").click(function () {
                $("#add_emplacement").modal('show');
                $("#btn_text").text("Sauvegarder maintenant");
                $("#form_emplacement").get(0).reset();
                $("#emplacement_id").val('')
                $("#addEmplacement").text('Ajouter Un Nouvel Emplacement')
            })
            $("button[type='reset']").click(function () {
                $("#type_id").val('')
                $("#form_emplacement").get(0).reset();
                $("#add_emplacement").modal('hide');
            })
            $('body').on('click','#edit_emplacement', function () {
                let type_id = $(this).data('id');
                $.get('/dashboard/emplacements/'+type_id, function (data) {
                    console.log(data)
                    $("#ville").val(data.ville);
                    $("#commune").val(data.commune);
                    $("#quartier").val(data.quartier);
                    $("#addEmplacement").text("Modification d'un emplacement");
                    $("#btn_text").text("Modifier Maintenant");
                    $("#emplacement_id").val(data.id);
                    $("#add_emplacement").modal("show");
                })
            })
            $('body').on('click','#delete_emplacement',function () {
                let id = $(this).data('id');
                if(confirm("Êtes-vous sûr de vouloir supprimer cet emplacement")){
                   $.get('/dashboard/emplacements/'+id+'/delete', function (data) {
                       console.log(data)
                   })
                }
            });

            $("#emplacement_dataTable").dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                language:{
                    url:'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'
                },
                ajax: {
                    url: '{{route('emplacement.home')}}',
                    type: 'GET'
                },
                columns: [
                    {data: 'id', name: 'id', 'visible': false},
                    {data: 'ville', name: 'ville'},
                    {data: 'commune', name: 'commune'},
                    {data: 'quartier', name: 'quartier'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order: [[0, 'desc']]
            })

            let form = $("#form_emplacement");
            if (form.length > 0){
                form.validate();
                form.on('submit', function(e){
                    e.preventDefault();
                    $("#btn_text").text('Envoie en cours...');
                    $.ajax({
                        data: new FormData(this),
                        url: '{{route('emplacement.store')}}',
                        type: 'POST',
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            toastr.success(data, 'OPERATION REUSSIE');
                            $("#form_emplacement").get(0).reset()
                            $("#emplacement_id").val('')
                            $("#btn_text").text("Sauvegarder maintenant");
                            $("#add_emplacement").modal('hide');
                            const TEmplt = $("#emplacement_dataTable").dataTable()
                            TEmplt.fnDraw(false);
                        },
                        error: function (data) {
                           switch (data.status) {
                               case 422:
                                   toastr.error("Un ou Plusieurs champs sont mal renseignés, rééssayer", 'Erreur Champ')
                               break;
                               case 500:
                                   toastr.info("Une erreur s'est produite lors de la communication avec le serveur","ERREUR SERVEUR")
                               break;
                               default:
                                   toastr.error("Désolé, nous n'avons pas pu terminer l'opération","ERREUR INCONNUE")
                           }
                        }
                    })
                })
            }
        });
    </script>
@endsection
