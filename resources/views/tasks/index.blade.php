@extends('auth.layout.app')

@section('title', 'Task List')

@section('content')
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Your Tasks</h3>
        <a href="{{ route('tasks.create') }}" class="btn btn-success">+ Add Task</a>
    </div>

    {{-- Search Form --}}
    <form action="{{ route('tasks.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search tasks..." value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($tasks->isEmpty())
        <div class="alert alert-info">No tasks found.</div>
    @else
        <div class="row">
            @foreach($tasks as $task)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $task->title }}</h5>
                            <p class="card-text">{{ $task->description }}</p>

                            <span class="badge
                                @if($task->status == 'pending') bg-warning text-dark
                                @elseif($task->status == 'in-progress') bg-info
                                @elseif($task->status == 'completed') bg-success
                                @endif">
                                {{ ucfirst($task->status) }}
                            </span>

                            <div class="mt-3 d-flex gap-2">
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">Edit</a>

                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination Links --}}
        <div class="d-flex justify-content-center">
            {!! $tasks->appends(['search' => request('search')])->links() !!}
        </div>
    @endif
</div>
@endsection
