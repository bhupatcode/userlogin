@extends('auth.layout.app')

@section('title','Dashboard')

@section('content')
<div class="container mt-5">
    <h2>Welcome, {{ $user_name }}</h2>
    <p>User ID: {{ $user_id }}</p>

    <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Edit Profile</a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger mt-3">Logout</button>
    </form>
</div>
@endsection
