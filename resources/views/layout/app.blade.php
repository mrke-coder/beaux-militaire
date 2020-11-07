<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTION DES BAUX - @yield('title')</title>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/datatables/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/select2-bootstrap4-theme/select2-bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/select2/css/select2.css')}}">
    <style type="text/css">
        *{
            box-sizing: border-box;
        }
        .error{
            color: red;
            font-size: 14px;
        }
        div.form-group > .form-control{
            width: 100% !important;
        }
        .ui.label {
            display: inline-block;
            line-height: 1;
            vertical-align: baseline;
            margin: 0 .14285714em;
            background-color: #e8e8e8;
            background-image: none;
            padding: .5833em .833em;
            color: rgba(0, 0, 0, .6);
            text-transform: none;
            font-weight: 700;
            border: 0 solid transparent;
            border-radius: .28571429rem;
            -webkit-transition: background .1s ease;
            transition: background .1s ease;
        }
        div.toast.toast-error{
            background-color: #e74a3b !important;
        }
        div.toast.toast-success{
            background-color: #1cc88a !important;
        }
        div.toast.toast-warning{
            background-color: #f6c23e !important;
        }
        div.toast.toast-info{
            background-color: #36b9cc !important;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- sideBar -->
        @include('inc.sideBar')
        <!-- end sideBar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('inc.topBar')
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">
                            Dashboard &nbsp;
                            @for ($i=2; $i<count(explode('/',$_SERVER['REQUEST_URI'])); $i++)
                                <i class="fa fa-chevron-right"></i>&nbsp;{{ucfirst(explode('/',$_SERVER['REQUEST_URI'])[$i])}}
                            @endfor
                        </h1>
                    </div>
                    @yield('content')
                </div>
            </div>
            @include('inc.footer')
        </div>
    </div>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Voulez-vous terminer votre session ?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Cliquez sur le bouton (oui) pour confirmer l'action.</div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">non</button>
                <a class="btn btn-success" href="{{route('logout')}}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">oui</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
<script src="{{asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/vendor/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/select2/js/select2.full.js')}}"></script>
<script src="{{asset('assets/js/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/js/localisation/messages_fr.min.js')}}"></script>
<script src="{{asset('assets/js/demo/datatables-demo.js')}}"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js">
    </script>
    <script>
        toastr.options ={
            'closeButton':true,
            'newestOnTop':true,
            'positionClass':'toast-top-center',
            'duration':3000
        }
    </script>
@yield('js')
</body>

</html>
