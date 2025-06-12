@extends('layouts.app')

@section('title', 'View Task #' . $userTask->id)

@section('content')
    <div class="container view-form">
        <h1>View Task #{{ $userTask->id }}</h1>

        <div class="view-section">
            <label>Title</label>
            <span class="value">{{ $userTask->title }}</span>
        </div>

        <div class="view-section">
            <label>Content</label>
            <span class="value">{{ $userTask->content }}</span>
        </div>

        <div class="view-section">
            <label>Task Status</label>
            <span class="value">{{ ucfirst($userTask->task_status ?? '—') }}</span>
        </div>

        <div class="view-section">
            <label>Publish Status</label>
            <span class="value">{{ ucfirst($userTask->publish_status) }}</span>
        </div>

        <div class="view-section">
            <label>Parent Task (optional)</label>
            <span class="value">{{ $userTask->parent_id ?? 'None'}}</span>
        </div>

        <div class="view-section">
            <label>Date Updated</label>
            <span class="value">{{ $userTask->date_updated ?? 'Not Updated' }}</span>
        </div>

        <div class="view-section">
            <label>Date Published</label>
            <span class="value">{{ $userTask->date_published ?? 'Not Published' }}</span>
        </div>

        <div class="view-section">
            <label>Attachment</label>
            <span class="value">
            @if ($userTask->attachment)
                <a href="{{ asset('images/' . $userTask->attachment) }}" target="_blank">View Attachment</a>
            @else
                No attachment
            @endif
            </span>
        </div>

        <a href="{{ route('user_tasks.index') }}" class="btn btn-info">Return</a>

    </div>
@endsection