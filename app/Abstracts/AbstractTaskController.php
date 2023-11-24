<?php

namespace App\Abstracts;

use App\Http\Controllers\API\ApiController;
use App\Services\Contracts\TaskServiceInterface;
use OpenApi\Annotations as OA;

/**
 *
 * @OA\Schema(
 *     schema="JsonResponse",
 *     title="Successful task deletion",
 *     @OA\Property(property="message", type="string", example="Success.")
 * )
 * @OA\Schema(
 *     schema="401",
 *     title="Unauthenticated access",
 *     @OA\Property(property="message", type="string", example="Unauthenticated.")
 * )
 * @OA\Schema(
 *     schema="403",
 *     title="Unauthorized access",
 *     @OA\Property(property="message", type="string", example="This action is unauthorized..")
 * )
 * @OA\Schema(
 *     schema="404",
 *     title="Resource Not Found",
 *     @OA\Property(property="message", type="string",
 *         example="No query results for model [Model] 9aaf739d-5aeb-4117-ab3a-829e635411172")
 * )
 */
abstract class AbstractTaskController extends ApiController
{
    public function __construct(protected TaskServiceInterface $iTaskService)
    {
    }
}
