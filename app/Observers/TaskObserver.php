<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\Task;

class TaskObserver
{

    /**
     * Handle the Task "deleted" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function deleting(Task $task){
        Log::where('task_id', $task->id)->delete();
    }

}
