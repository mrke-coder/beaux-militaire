<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTION DES BAUX - Authentification</title>
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/assets/vendors/iconfonts/mdi/css/materialdesignicons.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/assets/vendors/css/vendor.addons.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/assets/css/shared/style.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/assets/css/demo_1/style.css')}}">
    <link rel="shortcut icon" href="#" />
</head>

<body>
<div class="authentication-theme auth-style_1">
    <div class="row">
        <div class="col-12 logo-section">
            <a href="javascript:void(0)" class="logo">
                <img src="{{asset('assets/img/logo.png')}}" alt="logo" />
            </a>
        </div>
    </div>
    @yield('content')
    <div class="auth_footer">
        <p class="text-muted text-center">© Base Aérienne d'Abidjan 2020</p>
    </div>
</div>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/assets/vendors/js/core.js')}}"></script>
<script src="{{asset('assets/assets/vendors/js/vendor.addons.js')}}"></script>
<script src="{{asset('assets/assets/js/template.js')}}"></script>
</body>

</html>

