@extends('auth.layout.app')

@section('title','Homepage')

@section('content')

 <a href="{{ route('showregister') }}" class="btn btn-primary">Register</a>
    <a href="{{ route('showlogin') }}" class="btn btn-success">Login</a>


@endsection
