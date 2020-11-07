@extends('layout.app')
@section('title')
    Proprietaire informations
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
    <style>
        .card{
            background: #fff;
            min-height: 50px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            position: relative;
            margin-bottom: 30px;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            -ms-border-radius: 2px;
            border-radius: 2px;
        }
        .profile-card .profile-header {
            background-color: #33559c;
            padding: 42px 0;
        }
        .profile-card .profile-body .image-area img {
            padding: 2px;
            margin: 2px;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            -ms-border-radius: 50%;
            border-radius: 50%;
            width: 200px;
            height: auto;
        }
        .profile-card .profile-body .content-area {
            text-align: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }
        .profile-card .profile-footer {
            padding: 15px;
        }
        .profile-card .profile-footer ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .profile-card .profile-footer ul li {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .profile-card .profile-footer ul li span:first-child {
            font-weight: bold;
        }
        .profile-card .profile-footer ul li span:last-child {
            float: right;
        }
        .profile-card .profile-body .image-area {
            text-align: center;
            margin-top: -64px;
        }
        .card .header {
            color: #555;
            padding: 20px;
            position: relative;
            border-bottom: 1px solid rgba(204, 204, 204, 0.35);
        }
        .card .header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: normal;
            color: #111;
        }
        .card .body {
            font-size: 14px;
            color: #555;
            padding: 20px;
        }
        .card-about-me .body ul li {
            border-bottom: 1px solid #eee;
            margin-bottom: 10px;
            padding-bottom: 15px;
        }
        .card-about-me .body ul li .title {
            font-weight: bold;
            color: #666;
        }
        .card-about-me .body ul li .title i {
            margin-right: 2px;
            position: relative;
            top: 7px;
        }
        .card-about-me .body ul li .content {
            margin-top: 10px;
            color: #999;
            font-size: 13px;
        }
        .card-about-me .body ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
    </style>
    <div class="row">
        <div class="col-lg-3 col-sm-12 col-xs-12"></div>
        <div class="col-xs-12 col-sm-12 col-lg-6">
            <div class="card profile-card">
                <div class="profile-header">&nbsp;</div>
                <div class="profile-body">
                    <div class="image-area">
                        <img src="{{$proprietaire->photo ? $proprietaire->photo : asset('assets/assets/images/profile/user.png') }}" alt="Image" />
                    </div>
                    <div class="content-area">
                        <h3>{{$proprietaire->civilite === 'M/Mr' ? 'M.': 'Mme'}}&nbsp;{{$proprietaire->nom.' '.$proprietaire->prenoms}}</h3>
                    </div>
                </div>
                <div class="profile-footer">
                    <ul>
                        <li>
                            Contacts: {{$proprietaire->contact}} <br>
                            Adresse Email: {{$proprietaire->email}}<br>
                            Enregistré le: {{\App\Http\Repositories\UploadRepository::formatDate($proprietaire->created_at)}}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card card-about-me">
                <div class="header">
                    <h2>LISTE DES LOGEMENTS</h2>
                </div>
                <div class="body">
                    <ul>
                        @if(count($logements) >0)
                            @foreach($logements as $logement)
                        <li>
                            <div class="title">
                                <i class="fa fa-map-marker"></i>
                                <span>{{$logement->ville.', '.$logement->commune.' - '.$logement->quartier}}</span>&nbsp;
                            </div>
                            <div class="content">
                                <span>{{$logement->description}} de {{$logement->nombre_piece.' pièces'}}</span><br>
                                Occupé par: {{$logement->nom_mili.' '.$logement->prenom_mili}}, joignable au {{$logement->phone}}
                                <br>
                                Bail débuté dépuis le : {{\App\Http\Repositories\UploadRepository::formatDate($logement->created_at)}}
                            </div>
                        </li>
                            @endforeach
                        @else
                            <strong style="color: red">Pas de logements enregistré pour ce propriétaire</strong>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-12 col-xs-12"></div>
    </div>
@endsection
