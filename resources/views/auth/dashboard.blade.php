@extends('auth.layout.app')

@section('title','Dashboard')

@section('content')
<div class="container mt-5 text-center">
    <h2>Welcome, {{ $user_name }}</h2>
    <p>User ID: {{ $user_id }}</p>

    <!-- ✅ Profile Image -->
    <div class="my-4">
        <img src="{{ Auth::user()->profile_image ? asset('uploads/profile/' . Auth::user()->profile_image) : asset('default/profile.png') }}"
             alt="Profile Image" class="rounded-circle" width="150" height="150">
    </div>

    <!-- ✅ Buttons -->
    <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Edit Profile</a>
    <a href="{{ route('tasks.index') }}" class="btn btn-primary mt-3">Tasks Manage</a>

    <form method="POST" action="{{ route('logout') }}" class="d-inline">
        @csrf
        <button class="btn btn-danger mt-3">Logout</button>
    </form>
</div>
@endsection
