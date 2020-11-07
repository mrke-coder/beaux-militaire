@extends('layout.app')
@section('title')
    Militaires
@endsection
@section('militaire-active')
    active
@endsection
@section('content')
    <p class="mb-4">
        <a href="javascript:void(0)" class="btn btn-primary" id="btn_add"><i class="fa fa-plus-circle"></i> Nouveau militaire</a>
    </p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">LISTES DES MILITAIRES ENREGISTRES</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped dt-responsive nowrap" id="militaire_dataTable" width="100%">
                    <thead>
                    <tr>

                        <th>ID</th>
                        <th>PHOTO</th>
                        <th>NOM</th>
                        <th>PRENOMS</th>
                        <th>CONTACT</th>
                        <th>GRADES</th>
                        <th>ENREGISTRE LE</th>
                        <th>ACTIONS</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_militaire" tabindex="-1" role="dialog" aria-labelledby="addMilitaire" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMilitaire"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="new_militaire" autocomplete="off" method="POST">
                        @csrf
                        <input type="hidden" name="militaire_id" id="militaire_id" class="form-control">
                       <div class="row">
                           <div class="col-md-6 col-sm-12">
                               <div class="form-group">
                                   <label for="grade">Grade du minitaire</label>
                                   <select class="select2bs4" name="grade[]" id="grade"
                                           multiple="multiple"
                                           data-placeholder="Selectionner le(s) grade(s) du militaire"
                                           style="width: 100%;" required>
                                       @foreach(\App\Models\Grade::latest()->get() as $grade)
                                           <option value="{{$grade->id}}">{{$grade->grade.' - '.$grade->code}}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                           <div class="col-md-6 col-sm-12">
                               <div class="form-group">
                                   <label for="mecano">Mecano du militaire <span class="required">*</span></label>
                                   <input type="number" name="mecano" id="mecano" class="form-control" required placeholder="Entrer le mecano">
                               </div>
                           </div>
                           <div class="col-md-6 col-sm-12">
                               <div class="form-group">
                                   <label>Situation Matrimoniale <span class="required">*</span></label><br>
                                   <div class="custom-control custom-radio custom-control-inline">
                                       <input type="radio" value="Marié(e)" id="situation_matrimoniale" name="situation_matrimoniale" class="custom-control-input" checked>
                                       <label class="custom-control-label" for="situation_matrimoniale">Marié(e)</label>
                                   </div>
                                   <div class="custom-control custom-radio custom-control-inline">
                                       <input type="radio" value="Célibataire" id="situation_matrimoniale1" name="situation_matrimoniale" class="custom-control-input">
                                       <label class="custom-control-label" for="situation_matrimoniale1">Célibataire</label>
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-6 col-sm-12">
                               <div class="form-group">
                                   <label for="unite_militaire">Unité du militaire <span class="required">*</span></label>
                                   <input type="text" name="unite_militaire" id="unite_militaire" class="form-control" required placeholder="Entrer l'unité du militaire">
                               </div>
                           </div>
                           <div class="col-md-6 col-sm-12">
                               <div class="form-group">
                                   <label  for="nom">Nom De Famille <span class="required">*</span></label>
                                   <input autocomplete="off" type="text" name="nom" id="nom" class="form-control" required placeholder="Entrer nom de famille">
                               </div>
                           </div>
                           <div class="col-md-6 col-sm-12">
                               <div class="form-group">
                                   <label for="nom">Prénoms <span class="required">*</span></label>
                                   <input autocomplete="off" type="text" name="prenom" id="prenom" class="form-control" required placeholder="Entrer Prénoms">
                               </div>
                           </div>
                           <div class="col-md-6 col-sm-12">
                              <div class="form-group">
                                  <label for="date_naissance">Date de naissance <span class="required">*</span></label>
                                  <input type="date" name="date_naissance" id="date_naissance" class="form-control" required placeholder="Entrer date de naissance">
                              </div>
                           </div>
                           <div class="col-md-6 col-sm-12">
                               <div class="form-group">
                                   <label for="lieu_naissance">Lieu de naissance <span class="required">*</span></label>
                                   <input type="text" name="lieu_naissance" id="lieu_naissance" class="form-control" required placeholder="Entrer lieu de naissance">
                               </div>
                           </div>
                           <div class="col-md-6 col-sm-12">
                               <div class="form-group">
                                   <label for="adresse_email">Adresse E-mail <span class="required">*</span></label>
                                   <input type="email" name="adresse_email" id="adresse_email" class="form-control" placeholder="Entrer l'adresse e-mail">
                               </div>
                           </div>
                            <div class="col-md-6 col-sm-12">
                               <div class="form-group">
                                   <label for="contact">Contacts Téléphoniques <span class="required">*</span></label>
                                   <input type="text" name="contact" id="contact" class="form-control" required placeholder="Entrer contacts téléphoniques">
                               </div>
                           </div>
                           <div class="form-group">
                              <div class="col-md-12 col-sm-12">
                                  <button class="btn btn-danger" type="reset" id="reset_btn"><i class="fa fa-close"></i> Annuler</button>
                                  <button class="btn btn-success" type="submit"><i class="fa fa-check-circle"></i> <span id="save_btn_text"></span></button>
                              </div>
                           </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_photo" tabindex="-1" role="dialog" aria-labelledby="addPhoto" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPhoto">Nouvelle photo</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="row" style="justify-content: center">
                    <img style="border-radius: 100%; width: 80px;height: 80px" src="{{asset('assets/img/rotating_card_profile2.png')}}" id="photo_display" class="img-profile">
                </div>
                <form id="form_photo_militaire" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="hidden" name="militaire_id" id="m_id">
                    <div class="form-group">
                        <label for="photo">Photo *</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="photo01">
                                <i class="fa fa-upload"></i>
                            </span>
                            </div>
                            <input type="file"
                                   class="form-control" id="photo"
                                   name="photo"
                                   placeholder="Choisir une photo"
                                   required
                                   onchange="attache_image()"
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="reset" class="btn btn-danger" id="reset_photo_form"><i  class="fa fa-window-close"></i> Annuler</button>
                        <button type="submit" class="btn btn-success"><i  class="fa fa-check-circle"></i> Valider</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_grade" tabindex="-1" role="dialog" aria-labelledby="addGrade" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGrade">Nouveaux grades pour - <span id="nom_mili"></span></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_grade_militaire" method="POST">
                        @csrf
                        <input type="hidden" class="form-control" name="militaire_id" id="m_id_grade">
                        <div class="form-group">
                            <label for="grade">Grade du minitaire</label>
                            <select class="select2bs4" name="grade[]" id="grade_1"
                                    multiple="multiple"
                                    data-placeholder="Selectionner le(s) grade(s) du militaire"
                                    style="width: 100%;" required>
                                @foreach(\App\Models\Grade::latest()->get() as $grade)
                                    <option value="{{$grade->id}}">{{$grade->grade.' - '.$grade->code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="reset" id="reset_form_grade"><i class="fa fa-window-close-o"></i> Annuler</button>
                            <button class="btn btn-success" type="submit"><i class="fa fa-check-circle"></i> Valider</button>
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
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
            $('#grade_1').select2({
                theme: 'bootstrap4'
            });
            $("#btn_add").on('click', function () {
                $("#add_militaire").modal('show');
                $("#addMilitaire").text('NOUVEAU MILITAIRE');
                $("#save_btn_text").text('Sauvegarder maintenant');
                $("form#new_militaire").get(0).reset()
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#militaire_dataTable").DataTable({
                serverSide: true,
                responsive: true,
                processing:true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json'
                },
                ajax:{
                    url: '{{route('militaire.home')}}',
                    type: 'GET'
                },
                columns:[
                    {data:'id',name:'id','visible':false},
                    {data:'photo',name: 'photo'},
                    {data: 'nom', name:'nom'},
                    {data: 'prenom', name:'prenom'},
                    {data: 'contact', name:'contact'},
                    {data: 'grade', name: 'grade'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name:'action', orderable:false, searchable:false}
                ],
                order:[[0, 'desc']]
            });

            $("#reset_btn").click(function (){
                $("#new_militaire").get(0).reset();
                $("#militaire_id").val('');
                $("#add_militaire").modal('hide');

            });

            $("#reset_photo_form").click(function () {
               $("#form_photo_militaire").get(0).reset();
               $("input#m_id").val('');
               $("#add_photo").modal('hide');
            });

            $("#reset_form_grade").click(function () {
                $("#form_grade_militaire").get(0).reset();
                $("input#m_id_grade").val('');
                $("#add_grade").modal('hide');
            });
            const body =  $('body');

            body.on('click','#edit_militaire',function (){
                let militaire_id = $(this).data('id');
                $.get('/dashboard/militaire/'+militaire_id, function (data) {
                    $("#save_btn_text").text('Modifier maintenant');
                    $("#militaire_id").val(data.id);
                    $("#mecano").val(data.mecano);
                    $("#nom").val(data.nom);
                    $("#prenom").val(data.prenom)
                    $("#date_naissance").val(data.date_naissance);
                    $("#lieu_naissance").val(data.lieu_naissance);
                    $("#adresse_email").val(data.adresse_email);
                    $("#contact").val(data.contact);
                    $("#unite_militaire").val(data.unite_militaire)
                    $("#add_militaire").modal('show');
                });
            });



           body.on('click', '#delete_militaire', function (){
                let militaire_id = $(this).data('id');
                if (confirm('Êtes-vous sûr de vouloir supprimer ce militaire ?')){
                    $.ajax({
                        type: 'GET',
                        url: '/dashboard/militaire/delete/'+militaire_id,
                        success: function (data) {
                            const MTable = $("#militaire_dataTable").dataTable();
                            MTable.fnDraw(false);
                            toastr.success(data,"SUPPRESSION REUSSIE")
                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error("Erreur survenue lors de la mise en corbeille", "Echec suppression");
                        }
                    });
                }
            });

            body.on('click', '#avatar_militaire', function () {
                let m_id = $(this).data('id');
                $.get('/dashboard/militaire/'+m_id, function (data) {
                    $("#m_id").val(data.id);
                    $("#add_photo").modal('show');
                })
            });

            body.on('click','#graduate_militaire', function (){
               let m_id_grade = $(this).data('id');
               $.get('/dashboard/militaire/'+m_id_grade, function (data){
                   $("#m_id_grade").val(data.id)
                  $("span#nom_mili").text(data.prenom+' '+data.nom);
                  $("#add_grade").modal('show');
               });
            });

            let form_militaire = $("form#new_militaire");
            form_militaire.validate();
            if (form_militaire.length > 0){
                form_militaire.on('submit', function (e) {
                    e.preventDefault();
                    $("save_btn_text").text('Envoie en cours...')
                    $.ajax({
                        url:'{{route('militaire.store')}}',
                        type: 'POST',
                        data: $("form#new_militaire").serialize(),
                        success: function (data){
                            console.log(data)
                            form_militaire.get(0).reset();
                            $("#militaire_id").val('');
                            $("#save_btn_text").text("Enregistrer maintenant");
                            $("#add_militaire").modal('hide');
                            const MTable = $("#militaire_dataTable").dataTable();
                            MTable.fnDraw(false);
                            toastr.success(data.message,'SAUVEGARDE REUSSIE');
                        },
                        error: function (data){
                            switch (data.status) {
                                case 422:
                                    toastr.error("un ou plusieurs champs ne sont pas correctement remplis","SAUVEGARDE ECHOUEE");
                                    break;
                                case 500: toastr.error("Erreur survenue lors de la communication avec le serveur","ERREUR SERVEUR");
                                    break;
                                default: toastr.warning("Attention nous rencontrons une erreur non enregistrée","ERREUR INCONNUE")
                            }
                        }
                    })
                });
            }

            let  form_militaire_grade = $("form#form_grade_militaire");

            form_militaire_grade.validate();
            if (form_militaire_grade.length>0){
               form_militaire_grade.on('submit', function (e) {
                   e.preventDefault();
                   $.ajax({
                       data: $("#form_grade_militaire").serialize(),
                       url:'{{route('militaire.store_grade')}}',
                       type: 'POST',
                       success: function (data) {
                           if (data.exist_errors.length >0){
                               toastr.warning("Un ou plusieurs grades existe(ent) donc nous les avons ignorés",'Sauvegarde réussie');
                           } else {
                               toastr.success(data.message,'Sauvegarde réussie')
                           }
                           const MTable = $("#militaire_dataTable").dataTable();
                           MTable.fnDraw(false);
                           $("#form_grade_militaire").get(0).reset();
                           $("#m_id_grade").val('');
                           $("#add_grade").modal('hide')
                       },
                       error: function (data) {
                           console.log(data)
                       }
                   })
               })
            }

            let form_photo = $("#form_photo_militaire");
            form_photo.validate();
            if (form_photo.length > 0){
                $("#form_photo_militaire").on("submit", function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: '{{route('militaire.photo')}}',
                        type: 'POST',
                        data: new FormData(this),
                        dataType:'JSON',
                        contentType:false,
                        cache:false,
                        processData: false,
                        success: function (data) {
                            $("#add_photo").modal('hide');
                            $("#form_photo_militaire").get(0).reset();
                            const MTable = $("#militaire_dataTable").dataTable();
                            MTable.fnDraw(false);
                            toastr.success("Photo Téléchargéé avec succès","TELECHARGEMENT REUSSI")
                        },
                        error: function (data) {
                            console.log(data)
                            switch (data.status) {
                                case 422:
                                    toastr.error(data.responseJSON.photo[0],'Eurreur champ');
                                    break;
                                case 500:
                                    toastr.info('Erreur serveur, réessayer uterieurement','Erreur Serveur');
                                    break;
                                default:
                                    toastr.warning('Erreur non répertoriée, en cas de persistence appelez votre développeur','Erreur inconnue');
                            }
                        }
                    })
                })
            }
        });
        function attache_image() {
            const image = document.getElementById('photo').files[0];
            if (image.type && image.type.indexOf('image') === -1){
                toastr.error("Désolé, vous devrez selectionner un fichier image");
            } else {
                let reader = new FileReader()
                reader.addEventListener('load', function () {
                    $("#photo_display").attr('src',reader.result);
                }.bind(this), false);

                reader.readAsDataURL(image)
            }
        }
    </script>
@endsection

