@extends('auth.layout.app')

@section('title','Login')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->has('email'))
    <div class="alert alert-danger">
        {{ $errors->first('email') }}
    </div>
@endif

<h2 class="text-center">Login Form</h2>
<div class="container mt-5">
    <form action="{{ route('login') }}" method="POST" id="loginform">
        @csrf

        <div>
            <label for="" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>

        <div>
            <label for="" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <button type="submit" name="login" class="btn btn-success mt-3">Login</button>
    </form>
</div>
@endsection
