@extends('layout.auth')
@section('content')
    <style>
        img.img-profile {
            width: 100px;
            height: 100px;
        }
    </style>
    @if ($message = session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-close"></i> {{$message}}.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-5 col-md-7 col-sm-9 col-11 mx-auto">
            <div class="grid">
                <div class="grid-body">
                    <div class="row">
                        <div class="col-lg-7 col-md-8 col-sm-9 col-12 mx-auto form-wrapper">
                            <form autocomplete="off" method="post" id="login" action="{{route('login')}}">
                                @csrf
                                <div class="form-group input-rounded">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="Username" value="{{old('username')}}" />
                                    @error('username')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group input-rounded">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" />
                                    @error('password')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-block"> S'identifier </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
