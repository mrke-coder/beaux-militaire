@extends('layout.app')
@section('title')
    Type De Logement
@endsection

@section('logement-active')
    active
@endsection
@section('logement-show')
    show
@endsection
@section('type_l-active')
    active
@endsection
@section('content')
    <p class="mb-4">
        <a href="javascript:void(0)"
           class="btn btn-primary"
           id="btn_add">
            <i class="fa fa-plus-circle"></i>
            Nouveau Type De Logement
        </a>
    </p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">LISTES DES TYPES DE LOGEMENTS</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped dt-responsive nowrap" id="typeDeLogement_dataTable" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>DESCRIPTION</th>
                        <th>ENREGISTRE LE</th>
                        <th>ACTIONS</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="typeLogement_modal" tabindex="-1" role="dialog" aria-labelledby="typeModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="typeModal">Voulez-vous terminer votre session ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" autocomplete="off" id="typeForm">
                        @csrf
                        <input type="hidden" name="type_id" id="type_id">
                        <div class="form-group">
                            <label for="description">Descripte du type de logement</label>
                            <input type="text" name="description" id="description" class="form-control" placeholder="Entrer la desciprition du type de logement" required>
                        </div>
                        <div class="form-group">
                            <button type="reset" class="btn btn-danger"><i class="fa fa-close"></i> Annuler</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> <span id="btn_text"></span> </button>
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
                $("#typeLogement_modal").modal('show');
                $("#btn_text").text("Sauvegarder maintenant")
                $("#type_id").val('')
                $("#typeForm").get(0).reset();
            });

            $("button[type='reset']").click(function (){
                $("#type_id").val('');
                $('#typeForm').get(0).reset();
                $("#typeLogement_modal").modal('hide')
            });

            $("#typeDeLogement_dataTable").dataTable({
                serverSide:true,
                responsive:true,
                processing: true,
                language:{
                    url:'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'
                },
                ajax:{
                    url: '{{route('typeL.home')}}',
                    type: 'GET'
                },
                columns:[
                    {data:'id',name:'id','visible':false},
                    {data: 'description', name: 'description'},
                    {data: 'created_at', name: 'created_at'},
                    {data:'action',name: 'action', orderable:false, searchable:false}
                ],
                order: [[0, 'desc']]
            });

            $('body').on('click','#edit_typeDeLogement', function () {
                let id = $(this).data('id');
                $.get("/dashboard/type-de-logemets/"+id, function (data) {
                    console.log(data)
                    $("#description").val(data.description)
                    $("#type_id").val(data.id)
                    $("#typeLogement_modal").modal('show');
                    $("#btn_text").text('Modifier maintenant')
                });
            });

            $('body').on('click','#delete_typeDeLogement',function () {
                let _id = $(this).data('id');
                if (confirm("Êtes-vous sûr de vouloir supprimer ce type de logement ?")){
                    $.get('/dashboard/type-de-logemets/'+_id+'/delete', function (data) {
                        toastr.success(data, "SUPPRESSION REUSSIE");
                        const TpTable = $("#typeDeLogement_dataTable").dataTable();
                        TpTable.fnDraw(false);
                    });
                }
            });

            $("#typeForm").validate();
            if ($('#typeForm').length>0){
                $("#typeForm").on('submit', function (e) {
                    e.preventDefault();
                    $("#btn_text").text('Envoie en cours...')
                    $.ajax({
                        data: new FormData(this),
                        url: '{{route('typeL.store')}}',
                        type: 'POST',
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            toastr.success(data);
                            $("#typeForm").get(0).reset();
                            $("#type_id").val('')
                            $("#typeLogement_modal").modal('hide')
                            $("#btn_text").text('Sauvegarder maintenant');
                            const TypeTable = $("#typeDeLogement_dataTable").dataTable();
                            TypeTable.fnDraw(false);
                        },
                        error: function (data) {
                            console.log(data)
                            switch (data.status) {
                                case 422:
                                    toastr.error(data.responseJSON.description[0],'Erreur champ');
                                    break;
                                default:
                                    toastr.info("Erreur non repertorée",'Erreur inconnue');
                            }
                        }
                    })
                });
            }

        });
    </script>
@endsection

