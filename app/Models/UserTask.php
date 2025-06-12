<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    protected $table = 'user_task';
    protected $fillable = [
        'parent_id',
        'title',
        'content',
        'task_status',
        'publish_status',
        'created_by',
        'date_created',
        'date_updated',
        'date_published',
        'attachment',
    ];
    public $timestamps = false;
}
