<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Prunable;

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

    use Prunable;
    
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


    /**
     * Get the user that created the task.
     *
     * @return mixed
     */
    public function subTasks()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->where('publish_status', '<>', 'trashed')
            ->orderBy('date_created', 'desc');
    }


    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    
    /**
     * Determine which records should be pruned.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable(): Builder
    {
        return static::where('publish_status', 'trashed')
            ->where('date_updated', '<=', now()->subDays(30));
    }
}
