<?php

namespace App\Http\Resources;

use App\DTOs\Task\TaskForCollectionDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="TaskCollection",
 *     title="Task Success TaskCollection",
 *     @OA\Property(property="data", type="array", @OA\Items(
 *         @OA\Property(property="id", type="string", example="9aa91a70-b419-4bf7-95c9-37a09342ef66"),
 *         @OA\Property(property="parent_id", type="string", nullable=true, example=null),
 *         @OA\Property(property="user_id", type="string", example="9aa8bcd2-833c-4fef-bb0a-ab51967f925c"),
 *         @OA\Property(property="status", type="integer", example=1),
 *         @OA\Property(property="priority", type="integer", example=4),
 *         @OA\Property(property="title", type="string", example="Est optio unde."),
 *         @OA\Property(property="created_at", type="string", format="date-time",
 *           example="2023-11-20T20:07:17.000000Z"),
 *         @OA\Property(property="completed_at", type="string", format="date-time", nullable=true,
 *           example="2023-10-30 20:27:13"),
 *         @OA\Property(property="status_name", type="string", example="Done"),
 *         )
 *     ),
 *     @OA\Property(property="links", type="object",
 *         @OA\Property(property="first", type="string",
 *          example="http://some.site/api/users/9aa8bcd2-833c-4fef-bb0a-ab51967f925c/tasks?page=1"),
 *         @OA\Property(property="last", type="string",
 *          example="http://some.site/api/users/9aa8bcd2-833c-4fef-bb0a-ab51967f925c/tasks?page=5"),
 *         @OA\Property(property="prev", type="string", nullable=true, example=null),
 *         @OA\Property(property="next", type="string", nullable=true,
 *          example="http://some.site/api/users/9aa8bcd2-833c-4fef-bb0a-ab51967f925c/tasks?page=2"),
 *    ),
 *    @OA\Property(property="meta", type="object",
 *        @OA\Property(property="current_page", type="integer", example=1),
 *        @OA\Property(property="from", type="integer", example=1),
 *        @OA\Property(property="last_page", type="integer", example=5),
 *        @OA\Property(property="links", type="array",
 *            @OA\Items(type="object",
 *                @OA\Property(property="url", type="string", nullable=true, example=null),
 *                @OA\Property(property="label", type="string", example="&laquo; Previous"),
 *                @OA\Property(property="active", type="boolean", example=false),
 *            ),
 *            @OA\Items(type="object",
 *                @OA\Property(property="url", type="string",
 *                  example="http://some.site/api/users/9aa8bcd2-833c-4fef-bb0a-ab51967f925c/tasks?page=1"),
 *                @OA\Property(property="label", type="string", example="1"),
 *                @OA\Property(property="active", type="boolean", example=true),
 *            ),
 *            @OA\Items(type="object",
 *                @OA\Property(property="url", type="string",
 *                  example="http://some.site/api/users/9aa8bcd2-833c-4fef-bb0a-ab51967f925c/tasks?page=2"),
 *                @OA\Property(property="label", type="string", example="2"),
 *                @OA\Property(property="active", type="boolean", example=false),
 *            ),
 *            @OA\Items(type="object",
 *                @OA\Property(property="url", type="string",
 *                  example="http://some.site/api/users/9aa8bcd2-833c-4fef-bb0a-ab51967f925c/tasks?page=2"),
 *                @OA\Property(property="label", type="string", example="Next &raquo;"),
 *                @OA\Property(property="active", type="boolean", example=false),
 *            ),
 *        ),
 *            @OA\Property(property="path", type="string",
 *              example="http://some.site/api/users/9aa8bcd2-833c-4fef-bb0a-ab51967f925c/tasks"),
 *            @OA\Property(property="per_page", type="integer", example=2),
 *            @OA\Property(property="to", type="integer", example=2),
 *            @OA\Property(property="total", type="integer", example=10),
 *        ),
 *    ),
 * )
 */
class TaskCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            $this->collection->transform(function ($item) {
                $item->resource = TaskForCollectionDTO::from($item->resource);
                return $item;
            })
                ->toArray();
    }
}
