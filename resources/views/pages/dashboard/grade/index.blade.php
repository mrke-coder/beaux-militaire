@extends('layout.app')
@section('title')
    Militaires - Grades
@endsection

@section('grade-active')
    active
@endsection

@section('content')
    <p class="mb-4">
        <a href="javascript:void(0)"
           class="btn btn-primary"
           id="btn_add">
            <i class="fa fa-plus-circle"></i>
            Nouveau grade
        </a>
    </p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">LISTES DES GRADES ENREGISTRES</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped dt-responsive nowrap" id="grade_dataTable" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>CODE GRADE</th>
                        <th>GRADE</th>
                        <th>ENREGISTRE LE</th>
                        <th>ACTIONS</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_grade" tabindex="-1" role="dialog" aria-labelledby="addMilitaire" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMilitaire"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newGrade">
                        @csrf
                        <input type="hidden" name="grade_id" id="grade_id" class="form-control">
                            <div class="form-group">
                                <label for="code_grade">Code Du Grade</label>
                                <input type="text" name="code_grade" id="code_grade" class="form-control" required placeholder="Entrer Le Code Du Grade">
                            </div>
                            <div class="form-group">
                                <label for="grade">
                                    Libelle Du Grade
                                </label>
                                <input type="text" name="grade" class="form-control" id="grade" required placeholder="Entre Le Libelle Du Grade">
                            </div>
                            <div class="form-group">
                                <button type="reset" class="btn btn-danger"><i class="fa fa-close"></i> Annuler</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> <span id="save_btn_text"></span></button>
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
            $('#btn_add').click(function (){
                $('#add_grade').modal('show');
                $(".modal-title").text('Ajouter Nouveau Grade');
                $("#save_btn_text").text('Enregistrer maintenant');
                $("#newGrade").get(0).reset();
                $("#grade_id").val('')
            });

            $("button[type='reset']").on('click',function (){
               $("#newGrade").get(0);
               $("#grade_id").val('');
               $("#add_grade").modal('hide');
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            $("#grade_dataTable").DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                language:{
                    url:'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'
                },
                ajax:{
                    url: '{{route('grade.home')}}',
                    type: 'GET'
                },
                columns: [
                    {data: 'id', name: 'id', 'visible': false},
                    {data: 'code', name: 'code'},
                    {data: 'grade', name: 'grade'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name:'action', orderable:false, searchable:false}
                ],
                order: [[0, 'desc']]
            });
            const body =  $('body');

           body.on('click','#edit_grade', function () {
                let grade_id = $(this).data('id');

                $.get('/dashboard/grades-militaires/'+grade_id, function (data) {
                    $("#grade_id").val(data.id);
                    $("#code_grade").val(data.code);
                    $("#grade").val(data.grade);
                    $("#save_btn_text").text('Modifier maintenant');
                    $("#add_grade").modal('show');
                });
            });

            body.on('click', '#delete_grade', function () {
                let grade_id = $(this).data('id');

               if (confirm("Êtes-vous sûr de vouloir supprimer ce grade ?")){
                   $.ajax({
                       type: 'GET',
                       url: '/dashboard/grades-militaires/'+grade_id+'/delete',
                       success: function (data) {
                           toastr.success(data,'SUPPRESSION REUSSIE');
                           const GTable = $("#grade_dataTable").dataTable();
                           GTable.fnDraw(false);
                       },
                       error: function (data) {
                           console.log(data);
                           toastr.error("Quelque chose s'est mal passé, rééssayer ultérieuement", "SUPPRESSION ECHOUEE");
                       }
                   });
               }
            });

            let form = $('#newGrade');

            form.validate();
            if (form.length > 0){

                form.on('submit', function (e){
                    e.preventDefault();
                    $("#save_btn_text").text('Envoie en cours...');
                    $.ajax({
                        data: $("form#newGrade").serialize(),
                        url: '{{route('grade.store')}}',
                        type: 'POST',
                        success: function (data) {
                            toastr.success(data,'Sauvegarde réussie')
                            form.get(0).reset();
                            $("#save_btn_text").text('Enreistrer maintenant');
                            $("#add_grade").modal('hide');
                            const GTable = $("#grade_dataTable").dataTable()
                            GTable.fnDraw(false);
                        },
                        error: function (data) {
                            //console.log('Error ',data)
                            switch (data.status) {
                                case 422:
                                    toastr.error('Un ou Plusieur champs ne sont pas correctement remplis, vérifier et rééssayer','Erreur Champs');
                                    break;
                                case 500:
                                    toastr.error('Sauvegarde echouée, rééssayez ulterieurement','Erreur Serveur');
                                    break;
                                default:
                                    toastr.warning('Erreur non repertoriée, Rééssayer','Erreur inconnue');
                            }
                            $("#save_btn_text").text('Sauvegarder maintenant')
                        }
                    })
                })
            }
        });
    </script>
@endsection
