@extends('layout.app')
@section('title')
    Habilitations
@endsection
@section('users-show')
    show
@endsection
@section('role')
    active
@endsection
@section('content')
    <p class="mb-4">
        <a href="javascript:void(0)"
           class="btn btn-primary"
           id="btn_add">
            <i class="fa fa-plus"></i>
            Nouveau role
        </a>
    </p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">LISTES DES HAILITATIONS</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="role_dataTable" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ROLE</th>
                            <th>DESCRIPTION</th>
                            <th>N.USERS</th>
                            <th>ENREGISTRER LE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="role_modal" tabindex="-1" role="dialog" aria-labelledby="addRole" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRole"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="role_form" autocomplete="off">
                        @csrf
                        <input type="hidden" name="role_id" id="role_id">
                        <div class="form-group mb-3">
                            <label form="role">Role<span class="requis">*</span></label>
                            <input type="text" name="role" id="role" class="form-control" placeholder="Entrer le role" required>
                        </div>
                        <div class="form-group mb-3">
                            <label form="description">Description</label>
                            <input type="text" name="description" id="description" class="form-control" placeholder="Entrer la description du role">
                        </div>
                        <div class="form-group mb-3">
                            <button class="btn btn-danger" type="reset">Annuler</button>
                            <button class="btn btn-success" type="submit"><i class="fa fa-check-circle"></i> <span id="btn_text"></span></button>
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
            const modal = $("#role_modal");
            const dataTable = $("#role_dataTable");
            const form = $("#role_form");
            const body = $('body');
            let btn_text = $("#btn_text");



            $("#btn_add").click(function () {
                modal.modal('show');
                btn_text.text("Sauvgarder maintenant")
            });

            dataTable.dataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'
                },
                ajax:{
                    type: 'GET',
                    url: '{{route('habilitations.index')}}'
                },
                columns:[
                    {data: 'id', name: 'id', 'visible': false},
                    {data: 'role', name: 'role'},
                    {data: 'description', name: 'description'},
                    {data: 'user', name: 'user'},
                    {data: 'created_at',name:'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            body.on('click','#edit_role', function () {
                const role_id = $(this).data('id');
                $.get('/dashboard/habilitations/'+role_id, function (data) {
                    modal.modal("show");
                    $("#role_id").val(data.id);
                    $("#role").val(data.role);
                    $("#description").val(data.description);
                  btn_text.text('Modifier maintenant');
                })
            });

            body.on('click','#delete_role', function () {
                if(confirm("Êtes-vous sûr de vouloir supprimer ce role ?")){
                    const role_id = $(this).data('id');
                    $.get('/dashboard/habilitations/'+role_id, function (data) {

                    })
                }
            });

            if (form.length > 0) {
                form.validate({
                    submitHandler: function (form) {

                        $.ajax({
                            type: 'POST',
                            url: '{{route('habilitations.store')}}',
                            data: new FormData(form),
                            dataType: 'JSON',
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function (){
                                btn_text.text('Envoie en cours...');
                            },
                            success: function (data) {
                                btn_text.text('Sauvegarder maintenant');
                                modal.modal('hide');
                                $("#role_form").get(0).reset();
                                $("#role_id").val('');
                                const RTable = dataTable.dataTable();
                                RTable.fnDraw(false);
                                toastr.success(data, "OPERATION REUSSIE");
                            },
                            error: function (data) {
                                console.log(data);
                                switch (data.status) {
                                    case 422:
                                        toastr.error('Un ou Plusieurs ne sont pas correctement remplis.',"ERREUR CHAMPS");
                                        break;
                                    case 500:
                                        toastr.warning("Une erreur s'est declenchée lors de la connexion au serveur","ERREUR SERVEUR");
                                        break;
                                    default:
                                        toastr.error("Quelque s'est mal passée, rééssayer plus tard", "ERREUR INCONNUE")
                                }
                            }
                        })
                    }
                })
            }
        })
    </script>
@endsection
