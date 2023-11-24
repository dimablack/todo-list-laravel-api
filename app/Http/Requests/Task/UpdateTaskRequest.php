<?php

namespace App\Http\Requests\Task;

use App\Models\Task;
use App\Rules\ParentIdCanBeAssign;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UpdateTaskRequest",
 *     title="Update Task Request",
 *     description="Request body for updating an existing task",
 *     @OA\Property(property="parent_id", type="string", example="9aa8c264-462d-4a68-8c6d-09629cdb1127",
 *         description="Optional parent task ID", nullable=true),
 *     @OA\Property(property="priority", type="integer", example=3, description="Task priority level (1-5)"),
 *     @OA\Property(property="title", type="string", example="Task Title", description="Task title"),
 *     @OA\Property(property="description", type="string", example="Task Description",
 *         description="Optional task description", nullable=true)
 * )
 */
class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('task'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        /**@var Task $task*/
        $task = $this->route('task');
        return [
            'parent_id' => ['bail', 'sometimes', 'nullable', 'uuid', 'exists:tasks,id', Rule::notIn($task->id),
                new ParentIdCanBeAssign($task)],
            'priority' => ['required', 'integer', 'between:1,5'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
