@extends('auth.layout.app')

@section('title', 'My Profile')

@section('content')
<div class="container mt-5">
    <h3>My Profile</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3 text-center">
            <img src="{{ $user->profile_image_url }}" alt="Profile Image" width="150" height="150" class="rounded-circle mb-2">
            <div>
                <input type="file" name="profile_image" class="form-control w-50 mx-auto">
                <small class="text-muted">Allowed: JPG, PNG (max 2MB)</small>
            </div>
        </div>

        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
        </div>

        <button class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
