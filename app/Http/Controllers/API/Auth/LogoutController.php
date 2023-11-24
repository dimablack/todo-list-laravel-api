<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class LogoutController extends ApiController
{
    /**
     * @OA\Post(
     *     path="/api/sanctum/logout",
     *     summary="Logout user",
     *     tags={"Auth"},
     *     @OA\SecurityScheme(
     *         securityScheme="bearerAuth",
     *         in="header",
     *         name="bearerAuth",
     *         type="http",
     *         scheme="bearer",
     *         bearerFormat="JWT",
     *     ),
     *     security={
     *         {"token": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="success", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Wrong credentials response",
     *         @OA\JsonContent(ref="#/components/schemas/401")
     *     ),
     * )
     * @return JsonResponse A JSON response indicating successful logout
     */
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->responseMessage(__('api.auth.logout'));
    }
}
