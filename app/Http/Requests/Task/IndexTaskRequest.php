<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * @OA\Parameter(
 *     parameter="status",
 *     in="query",
 *     name="status",
 *     description="Filter by task status(e.g. 1 - Todo, 2 - Done)",
 *     example="1",
 *     @OA\Schema(type="string")
 * ),
 * @OA\Parameter(
 *     parameter="priority",
 *     in="query",
 *     name="priority",
 *     description="Filter by task priority",
 *     example="3",
 *     @OA\Schema(type="integer")
 * ),
 * @OA\Parameter(
 *     parameter="search",
 *     in="query",
 *     name="search",
 *     description="Full-text search in title or description",
 *     example="important task",
 *     @OA\Schema(type="string")
 * ),
 * @OA\Parameter(
 *     parameter="sort[0][field]",
 *     in="query",
 *     name="sort[0][field]",
 *     description="First sort field(in:created_at,completed_at,priority)",
 *     example="created_at",
 *     @OA\Schema(type="string")
 * ),
 * @OA\Parameter(
 *     parameter="sort[0][direct]",
 *     in="query",
 *     name="sort[0][direct]",
 *     description="First direction of sort field(in:asc,desc)",
 *     example="asc",
 *     @OA\Schema(type="string")
 * ),
 * @OA\Parameter(
 *     parameter="sort[1][field]",
 *     in="query",
 *     name="sort[1][field]",
 *     description="Second sort field(in:created_at,completed_at,priority)",
 *     example="priority",
 *     @OA\Schema(type="string")
 * ),
 * @OA\Parameter(
 *     parameter="sort[1][direct]",
 *     in="query",
 *     name="sort[1][direct]",
 *     description="Second direction of sort field(in:asc,desc)",
 *     example="desc",
 *     @OA\Schema(type="string")
 * ),
 */
class IndexTaskRequest extends FormRequest
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
            'status' => ['sometimes', Rule::in(TaskStatus::values())],
            'priority' => ['sometimes', 'integer', 'between:1,5'],
            'search' => ['sometimes', 'string'],
            'sort' => ['array', 'max:2'],
            'sort.*.field' => ['required', 'required_with:sort.*', 'in:created_at,completed_at,priority'],
            'sort.*.direct' => ['required', 'required_with:sort.*', 'in:asc,desc'],
        ];
    }
}
