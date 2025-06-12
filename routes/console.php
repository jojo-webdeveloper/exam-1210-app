<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\UserTask;

// Artisan 'inspire' command (built-in)
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule a command to prune trashed UserTasks older than 30 days, every day at midnight
Schedule::call(function () {
    UserTask::where('publish_status', 'trashed')
        ->where('date_updated', '<=', now()->subDays(30))
        ->delete();
})->daily();