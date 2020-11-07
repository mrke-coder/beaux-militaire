@extends('layout.auth')
@section('content')

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-12">
                    @if ($message = session('success'))
                        <div class="alert alert-dismissible alert-success">
                            <i class="fa fa-check-circle"></i>&nbsp; {{$message}}
                        </div>
                    @endif
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Créer un nouveau compte</h1>
                        </div>
                        <form class="user" autocomplete="off" method="post" action="{{route('auth.store')}}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user @error('firstName') is-invalid @enderror" id="lastName" name="firstName" placeholder="Prénoms" value="{{old('firstName')}}">
                                    @error('lastName')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user @error('lastName') is-invalid @enderror" id="lastName" name="lastName" placeholder="Nom De Famille" value="{{old('lastName')}}">
                                    @error('lastName')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user @error('username') is-invalid @enderror" id="username" name="username" placeholder="Nom d'utilisateur / identifiant" value="{{old('username')}}">
                                @error('username')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="password" name="password" placeholder="Mot De Passe">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" id="password_confirmation" name="password_confirmation" placeholder="Répéter Le Mot De Passe">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Enregistrer le compte
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
