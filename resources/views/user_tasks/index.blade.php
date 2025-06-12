@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="header-section">
            <h1>User Tasks</h1>
            <div class="button-group">
            <a href="{{ route('user_tasks.create') }}" class="btn btn-primary">+ New Task</a>
            <a href="/logout" class="btn btn-warning">Logout</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @php
            $directionToggle = request('direction') === 'asc' ? 'desc' : 'asc';
        @endphp

        <form method="GET" class="filter-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="status" class="form-label">Search Title:</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status:</label>
                    <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="todo" {{ ($status ?? '') === 'todo' ? 'selected' : '' }}>To-Do</option>
                        <option value="inprogress" {{ ($status ?? '') === 'inprogress' ? 'selected' : '' }}>In Progress
                        </option>
                        <option value="done" {{ ($status ?? '') === 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="per_page" class="form-label">Per Page:</label>
                    <select name="per_page" id="per_page" class="form-select" onchange="this.form.submit()">
                        @foreach([10, 20, 30, 40, 50, 60, 70, 80, 90, 100] as $n)
                            <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        @if(isset($tasks) && $tasks->count())
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">
                                <a href="?{{ http_build_query(array_merge(request()->all(), [
                                        'sort_field' => 'title',
                                        'direction' => request('sort_field') === 'title' ? $directionToggle : 'asc'
                                    ])) }}" class="sort-link">Title
                                    @if(request('sort_field') === 'title')
                                        <span class="sort-icon {{ request('direction') === 'asc' ? 'asc' : 'desc' }}">
                                            {{ request('direction') === 'asc' ? '↑' : '↓' }}
                                        </span>
                                    @endif
                                </a>
                            </th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Published?</th>
                            <th class="text-center">
                                <a href="?{{ http_build_query(array_merge(request()->all(), [
                                        'sort_field' => 'date_created',
                                        'direction' => request('sort_field') === 'date_created' ? $directionToggle : 'desc'
                                    ])) }}" class="sort-link">Date Created
                                    @if(request('sort_field') === 'date_created')
                                        <span class="sort-icon {{ request('direction') === 'asc' ? 'asc' : 'desc' }}">
                                            {{ request('direction') === 'asc' ? '↑' : '↓' }}
                                        </span>
                                    @endif
                                </a>
                            </th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td class="text-center">{{ $task->id }}</td>
                                <td>{{ $task->title }}</td>
                                <td class="text-center">
                                    <span class="status-badge status-{{ $task->task_status ?? 'unknown' }}">
                                        {{ $task->task_status ?? '—' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="publish-status">{{ $task->publish_status }}</span>
                                </td>
                                <td class="text-center">{{ $task->date_created }}</td>
                                <td class="text-center actions">
                                    <a href="{{ route('user_tasks.show', $task) }}" class="btn btn-info">View</a>
                                    <a href="{{ route('user_tasks.edit', $task) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('user_tasks.trash', $task) }}" method="POST" class="inline-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Move this task to Trash?')">Trash</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center py-3">
                <!-- <div>{{ $tasks->links() }} </div> -->
                <div class="pagination-modern">
                    <a href="{{ $tasks->previousPageUrl() ?: '#' }}"
                        class="arrow {{ $tasks->onFirstPage() ? 'disabled' : '' }}">&laquo;</a>

                    @foreach ($tasks->linkCollection() as $link)
                        @if ($link['url'])
                            <a href="{{ $link['url'] }}" class="{{ $link['active'] ? 'active' : '' }}">{{ $link['label'] }}</a>
                        @else
                            <span class="disabled">{{ $link['label'] }}</span>
                        @endif
                    @endforeach

                    <a href="{{ $tasks->nextPageUrl() ?: '#' }}"
                        class="arrow {{ $tasks->hasMorePages() ? '' : 'disabled' }}">&raquo;</a>
                </div>
            </div>
        @else
            <div class="no-data">
                <p>No tasks available.</p>
            </div>
        @endif
    </div>
@endsection