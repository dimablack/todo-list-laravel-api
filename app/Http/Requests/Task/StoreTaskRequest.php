<?php

namespace App\Http\Requests\Task;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="StoreTaskRequest",
 *     title="Store Task Request",
 *     description="Request body for creating a new task",
 *     @OA\Property(property="parent_id", type="string", example="9aa8c264-462d-4a68-8c6d-09629cdb1127",
 *         description="Optional parent task ID", nullable=true),
 *     @OA\Property(property="priority", type="integer", example=3, description="Task priority level (1-5)"),
 *     @OA\Property(property="title", type="string", example="Task Title", description="Task title"),
 *     @OA\Property(property="description", type="string", example="Task Description",
 *         description="Optional task description", nullable=true)
 * )
 */

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('check-user-from-route', $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'uuid', 'exists:tasks,id'],
            'priority' => ['required', 'integer', 'between:1,5'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}
