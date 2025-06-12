<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $task_status
 * @property string $publish_status
 * @property int $created_by
 * @property int|null $parent_id
 * @property string|null $attachment
 * @property string|null $date_created
 * @property string|null $date_updated
 * @property string|null $date_published
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|static where($column, $operator = null, $value = null, $boolean = 'and')
 */
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
