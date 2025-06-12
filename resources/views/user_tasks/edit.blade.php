@extends('layouts.app')

@section('title', 'Edit Task #' . $userTask->id)

@section('content')
    <div class="container">
        <div class="header-section"></div>
            <h1>Edit Task #{{ $userTask->id }}</h1>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user_tasks.update', $userTask) }}" method="POST" enctype="multipart/form-data" class="add-form">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $userTask->title) }}"
                    maxlength="100" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="content" class="form-control" rows="4"
                    required>{{ old('content', $userTask->content) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="task_status" class="form-label">Task Status</label>
                <select name="task_status" id="task_status" class="form-select">
                    <option value="">-- Select --</option>
                    @foreach(['todo', 'inprogress', 'done'] as $status)
                        <option value="{{ $status }}" {{ old('task_status', $userTask->task_status) === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="publish_status" class="form-label">Publish Status</label>
                <select name="publish_status" id="publish_status" class="form-select" required>
                    @foreach(['draft', 'published'] as $status)
                        <option value="{{ $status }}" {{ old('publish_status', $userTask->publish_status) === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Parent Task (optional)</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <option value="">-- None --</option>
                    @foreach($parentOptions as $id => $title)
                    <option value="{{ $id }}"
                        {{ old('parent_id', $userTask->parent_id ?? '') == $id ? ' selected' : '' }}>
                        {{ $title }}
                    </option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label>Attach File:</label><br>
                <input type="file" name="attachment"><br><br>
            </div>

            <button type="submit" class="btn btn-primary">Update Task</button>
            <a href="{{ route('user_tasks.index') }}" class="btn btn-warning">Cancel</a>
        </form>
    </div>
@endsection