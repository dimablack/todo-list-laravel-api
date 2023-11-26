<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="TaskResource",
 *     title="Task Success Response",
 *     @OA\Property(property="data", type="object",
 *         @OA\Property(property="id", type="string", example="9aa8c705-b08c-4d9a-ba1b-a8510a80bdac"),
 *         @OA\Property(property="parent_id", type="string", example="9aa8c705-b63c-40ec-b77b-0e5f91da7a74",
 *             nullable=true),
 *         @OA\Property(property="status", type="integer", example=0),
 *         @OA\Property(property="status_name", type="string", example="Todo"),
 *         @OA\Property(property="priority", type="integer", example=3),
 *         @OA\Property(property="title", type="string", example="Task Title"),
 *         @OA\Property(property="description", type="string", example="Task Description", nullable=true),
 *         @OA\Property(property="created_at", type="string", example="2000-01-01 23:59:59"),
 *         @OA\Property(property="completed_at", type="string", example=null, nullable=true),
 *         @OA\Property(property="children", type="array", @OA\Items(
 *             @OA\Property(property="id", type="string", example="211b028c-80e4-4c7d-9f70-9a0000000001"),
 *             @OA\Property(property="parent_id", type="string", example="93d92907-f7b1-4c89-914c-090000000000"),
 *             @OA\Property(property="status", type="integer", example=1),
 *             @OA\Property(property="priority", type="integer", example=2),
 *             @OA\Property(property="title", type="string", example="Ipsam et enim qui."),
 *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-11-26 18:09:42"),
 *             @OA\Property(property="completed_at", type="string", format="date-time", nullable=true, example=null),
 *             @OA\Property(property="children", type="array", @OA\Items())
 *             ))
 *     )
 * )
 */
class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
