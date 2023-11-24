<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponsableTrait;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Todo List Api Version 1", version="1.0.0"),
 * @OA\PathItem(path="/api/")
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     description = "Enter Bearer Token",
 *     securityScheme="token",
 *       bearerFormat = "JWT",
 * )
 */
class ApiController extends Controller
{
    use ApiResponsableTrait;
}
