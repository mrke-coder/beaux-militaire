@extends('layout.app')
@section('title')
    Logement - Informations
@endsection
@section('l_actuel-active')
    active
@endsection

@section('logement-show')
    show
@endsection

@section('content')
    {{$militaire}}
    {{$logement}}
@endsection
