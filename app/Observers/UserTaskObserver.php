<?php

namespace App\Observers;

use App\Models\UserTask;

class UserTaskObserver
{

    /**
     * Handle the UserTask "updated" event
     * 
     * This method checks if a subtask's status changes and updates the parent task's status to 'done' if all subtasks are completed.
     * It only processes subtasks (i.e., tasks with a non-null parent_id).
     * 
     * @param UserTask $task
     * @return void
     */
    public function updated(UserTask $task): void
    {
        // Only consider when a subtask’s status changes
        if ($task->parent_id === null && $task->isDirty('task_status')) {
            return; // skip if it's a top-level task
        }

        if ($parent = $task->parent()->first()) {
            $allDone = $parent->subTasks()->count() > 0
                && $parent->subTasks()->where('task_status', '!=', 'done')->count() === 0;

            if ($allDone && $parent->task_status !== 'done') {
                $parent->update(['task_status' => 'done']);
            }
        }
    }

    /**
     * Handle the UserTask "deleted" event.
     */
    public function deleted(UserTask $task): void
    {
        //
    }


    /**
     * Handle the UserTask "force deleted" event.
     */
    public function forceDeleted(UserTask $task): void
    {
        //
    }
}
