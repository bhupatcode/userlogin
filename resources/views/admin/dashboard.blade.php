@extends('auth.layout.app')

@section('title','Admin Dashboard')

@section('content')
    <h2>welcome To Admin Panel</h2>
        <h2>Welcome, {{ $admin_name }}</h2>
    <p>User ID: {{ $admin_id }}</p>
    <form method="POST" action="{{ route('logout') }}" class="d-inline">
        @csrf
        <button class="btn btn-danger mt-3">Logout</button>
    </form>
@endsection
