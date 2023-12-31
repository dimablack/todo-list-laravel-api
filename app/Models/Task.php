<?php

namespace App\Models;

use App\Components\TaskTraversal;
use App\DTOs\RequestDTO\FilterTaskDTO;
use App\DTOs\RequestDTO\SortTaskDTO;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property mixed $parent_id
 * @property string $userId
 * @property TaskStatus $status
 * @property int $priority
 * @property string $user_id
 * @property string $title
 * @property $children

 */
class Task extends Model
{
    use HasFactory;
    use HasUuids;

    public const UPDATED_AT = null;

    protected $fillable = ['parent_id', 'status', 'priority', 'title', 'description', 'completed_at'];

    protected $appends = ['status_name'];

    protected $casts = [
        'status' => TaskStatus::class,
    ];

    /**
     * Get the user associated with the task.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the human-readable name of the task status.
     *
     * @return string
     */
    public function getStatusNameAttribute(): string
    {
        return ucfirst(strtolower($this->status->name));
    }

    /**
     * Get the parent task of the current task.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    /**
     * Get the children tasks of the current task.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id')->with('children');
    }

    /**
     * Scope a query to filter by task status.
     *
     * @param Builder $query
     * @param mixed $value
     */
    public function scopeStatus(Builder $query, $value): void
    {
        $query->where('status', $value);
    }

    /**
     * Scope a query to filter by task priority.
     *
     * @param Builder $query
     * @param mixed $value
     */
    public function scopePriority(Builder $query, $value): void
    {
        $query->where('priority', $value);
    }

    /**
     * Scope a query to sort by specified column and direction.
     *
     * @param Builder $query
     * @param mixed $column
     * @param mixed $direction
     */
    public function scopeSortBy(Builder $query, $column, $direction): void
    {
        $query->orderBy($column, $direction);
    }

    /**
     * Scope a query to filter by task status and priority.
     *
     * @param Builder $query
     * @param FilterTaskDTO $filterTaskData
     */
    public function scopeFilterByFields(Builder $query, FilterTaskDTO $filterTaskData): void
    {
        $query->when(
            !empty($filterTaskData->priority),
            fn ($query) => $query->priority($filterTaskData->priority)
        );

        $query->when(
            in_array($filterTaskData->status, TaskStatus::values()),
            fn ($query) => $query->status($filterTaskData->status)
        );
    }

    /**
     * Scope a query to sort by specified fields.
     *
     * @param Builder $query
     * @param FilterTaskDTO $filterTaskData
     */
    public function scopeSortByFields(Builder $query, FilterTaskDTO $filterTaskData): void
    {
        $query->when(!empty($filterTaskData->sortItems), function ($query) use ($filterTaskData) {
            /**@var SortTaskDTO $sortItem */
            foreach ($filterTaskData->sortItems as $sortItem) {
                $query->sortBy($sortItem->field, $sortItem->direct);
            }
        });
    }

    /**
     * Scope a query to perform a full-text search on title and description.
     *
     * @param Builder $query
     * @param FilterTaskDTO $filterTaskData
     */
    public function scopeFullTextSearch(Builder $query, FilterTaskDTO $filterTaskData): void
    {
        $query->when(
            !empty($filterTaskData->search),
            fn ($query) => $query->whereFullText(['title', 'description'], $filterTaskData->search)
        );
    }

    /**
     * Check if a specific condition is met for any task in the tree.
     *
     * @param callable $condition The condition callback.
     *
     * @return bool Returns true if the condition is met for any task, false otherwise.
     */
    private function checkIfTaskExistsInTree(callable $condition): bool
    {
        // Traverse the children tasks and check condition.
        return TaskTraversal::traverse($this, $condition);
    }

    /**
     * Check if the specified parent task exists among the children.
     *
     * @param string $parentId The ID of the parent task to check.
     *
     * @return bool Returns true if the parent task exists among the children, false otherwise.
     */
    public function checkIfParentAreInChildren(string $parentId): bool
    {
        return $this->checkIfTaskExistsInTree(function (Task $child) use ($parentId) {
            return $parentId === $child->id;
        });
    }

    /**
     * Check if there is any not completed task among the children.
     *
     * @return bool Returns true if there is any not completed task among the children, false otherwise.
     */
    public function checkIfExistNotCompletedInChildren(): bool
    {
        $statusToCheck = TaskStatus::TODO->value;

        return $this->checkIfTaskExistsInTree(function (Task $child) use ($statusToCheck) {
            return $statusToCheck === $child->status->value && $this->id !== $child->id;
        });
    }
}
