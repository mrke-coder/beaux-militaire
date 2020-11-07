@extends('layout.app')
@section('title')
    Utilisateurs
@endsection
@section('users-show')
    show
@endsection
@section('user')
    active
@endsection
@section('content')
    <p class="mb-4">
        <a href="javascript:void(0)"
           class="btn btn-primary"
           id="btn_add">
            <i class="fa fa-user-plus"></i>
            Nouvel utilisateur
        </a>
    </p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">LISTES DES UTILISATEURS</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" width="100%" id="users_dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>UTILISATEUR</th>
                            <th>HABILITATIONS</th>
                            <th>ENREGISTRE LE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="user_modal" tabindex="-1" role="dialog" aria-labelledby="addUser" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUser"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="display: none;" id="img_container">
                       <div class="col-lg-4"></div>
                       <div class="col-lg-4">
                           <img style="width: 100px; height: auto; border-radius: 100%"
                                id="avatar_display"
                                src="">
                       </div>
                       <div class="col-lg-4"></div>
                    </div>
                    <form id="user_form" autocomplete="off">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="user_id" name="user_id">
                            <div class="col-lg-12 col-sm-12"></div>
                            <div class="form-group mb-3 col-lg-6 col-sm-12">
                                <label for="avatar">CHOISIR UN IMAGE</label>
                                <input type="file" onchange="attach_image()" name="avatar" id="avatar" class="form-control" placeholder="Choisir une image">
                            </div>
                            <div class="form-group mb-3 col-lg-6 col-sm-12">
                                <label for="username">USERNAME / NOM D'UTILISATEUR</label>
                                <input type="text" name="username" id="username" class="form-control" required placeholder="ENTRER USERNAME / NOM D'UTILISTEUR">
                            </div>
                            <div class="form-group mb-3 col-lg-6 col-sm-12">
                                <label for="password">PASSWORD / MOT DE PASSE</label>
                                <input type="password" minlength="8" name="password" id="password" class="form-control" required placeholder="ENTRER PASSWORD / MOT DE PASSE">
                            </div>
                            <div class="form-group mb-3 col-lg-6 col-sm-12">
                                <label for="password_confirmation">REPEAT PASSWORD / REPETER MOT DE PASSE</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="CONFIRMER MOT DE PASSE">
                            </div>
                            <div class="form-group mb-3 col-lg-6 col-sm-12">
                                <label for="firstName">FIRST NAME / PRENOM</label>
                                <input type="text" name="firstName" id="firstName" class="form-control" required placeholder="ENTRER FIRST NAME / PRENOM">
                            </div>
                            <div class="form-group mb-3 col-lg-6 col-sm-12">
                                <label for="lastName">LAST NAME / NOM</label>
                                <input type="text" name="lastName" id="lastName" class="form-control" required placeholder="ENTRER LAST NAME / NOM">
                            </div>

                            <div class="form-group mb-3 col-lg-12 col-sm-12">
                                <button class="btn btn-danger" type="reset">Annuler</button>
                                <button class="btn btn-success" type="submit"><i class="fa fa-check-circle"></i> <span id="btn_text"></span></button>
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
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const modal = $("#user_modal");
            const form = $("#user_form");
            const user_id = $("#user_id");
            let btn_text = $("#btn_text");
            let modat_title= $("#addUser");
            const body = $('body');
            $("#btn_add").click(function () {
                modal.modal('show');
                form.get(0).reset();
                user_id.val('');
                btn_text.text('Sauvegarder maintenant')
            });
            $("button[type='reset']").click(()=>{
                modal.modal('hide');
                form.get(0).reset();
                user_id.val('');
            });


            $('#users_dataTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                language:{
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'
                },
                ajax:{
                    url: "{{route('user.home')}}",
                    type: 'GET'
                },
                columns:[
                    {data: 'id', name:'id', 'visible': false},
                    {data: 'user',name: 'user'},
                    {data: 'role', name:'role'},
                    {data: 'created_at', name:'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order: [[0, 'desc']]
            });


            body.on('click','#edit_user', function () {
                let user_id = $(this).data('id');
                $.get('/dashboard/utilisateurs/'+user_id, function (data) {
                    btn_text.text("Modifier maintenant");
                    $("#username").val(data.username);
                    $("#lastName").val(data.lastName);
                    $("#firstName").val(data.firstName);
                    $("#user_id").val(data.id);
                    $("#avatar").attr('src',data.avatar);
                    modat_title.text("MODIFICATION UTILISATEUR N°"+user_id);
                    modal.modal('show');
                });
            });


            body.on('click','#delete_user', function () {
                if(confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")){
                    const id = $(this).data('id');
                    console.log(id)
                }
            });

            if(form.length >0){
                form.validate({
                    rules: {
                        'password_confirmation': {
                            equalTo: '#password'
                        }
                    },
                    messages: {
                        'password_confirmation': {equalTo: "Le champ de confirmation mot de passe ne correspond pas."},
                        'password': {mineLength: 'Veuillez saisir une valeur supérieure ou égale à 8'}
                    },
                    submitHandler: function (form) {
                        btn_text.text("Envoie en cours...");
                        $.ajax({
                            data: new FormData(form),
                            url:"{{route('user.store')}}",
                            type: 'POST',
                            dataType: 'JSON',
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function (data) {
                                $("#user_form").get(0).reset();
                                modal.modal('hide');
                                btn_text.text("Sauvegarder maintenant");
                                const uTable = $("#users_dataTable").dataTable();
                                uTable.fnDraw(false);

                               toastr.success(data,"OPERATION REUSSIE")
                            },
                            error: function (data) {
                                btn_text.text("Sauvegarder maintenant");
                                switch (data.response.status) {
                                    case 422:
                                        toastr.error("Un ou Plusieurs champs ne sont pas correctement renseignés","ERREUR CHAMPS");
                                        break;
                                    case 500:
                                        toastr.warning("Erreur survenue lors de la connexion au serveur","ERREUR SERVEUR");
                                        break;
                                    default:
                                        toastr.info("Quelque chose s'est mal passée, rééssayer","ERREUR NON REPERTORIE")
                                }
                            }
                        })
                    }
                })
            }

        });

        function attach_image() {
            const image = document.getElementById('avatar').files[0];
            if(image.type && image.type.indexOf('image')===-1){
                toastr.error('selectionner un fichier image !');
            } else {
                let reader = new FileReader();
                reader.addEventListener('load', function () {
                    $("#avatar_display").attr('src', reader.result);
                }.bind(this), false);
                reader.readAsDataURL(image);

                $("#img_container").show()
            }
        }

    </script>
@endsection
