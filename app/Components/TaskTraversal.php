<?php

namespace App\Components;

use App\Models\Task;

class TaskTraversal
{
    /**
     * Traverse the task tree and invoke a callback for each task.
     *
     * @param Task     $task     The root task to start the traversal.
     * @param callable $callback The callback function to invoke for each task.
     *
     */
    public static function traverse(Task $task, callable $callback): bool
    {
        // Invoke the callback for the current task
        if ($callback($task)) {
            return true;
        }

        // Get the children tasks and invoke traverse for each of them
        foreach ($task->children as $child) {
            if (self::traverse($child, $callback)) {
                return true;
            }
        }

        // Return false if the callback never returned true
        return false;
    }
}
