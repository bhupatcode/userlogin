@extends('auth.layout.app')

@section('title', 'Task Create')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow rounded">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Create New Task</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Please fix the following errors:<br><br>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Task Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter task title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Task Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter task description (optional)"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Create Task</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary ms-2">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
