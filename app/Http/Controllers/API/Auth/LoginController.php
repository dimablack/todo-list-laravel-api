<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="422",
 *     title="Validation error response",
 *     @OA\Property(property="message", type="string"),
 *     @OA\Property(property="errors", type="object",
 *         @OA\Property(property="email", type="array", @OA\Items(type="string")),
 *         @OA\Property(property="password", type="array", @OA\Items(type="string"))
 *     )
 * )
 */
class LoginController extends ApiController
{
    /**
     * @OA\Post(
     *     path="/api/sanctum/token",
     *     summary="Create JWT token",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="test1@example.com"),
     *             @OA\Property(property="password", type="string", example="password"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="string", example="5fa8hgd2-563c-4rtf-bb0a-ab51967f456c"),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="email", type="string", example="test1@example.com"),
     *                     @OA\Property(property="email_verified_at", type="string", example="2023-11-20T12:00:00Z"),
     *                     @OA\Property(property="created_at", type="string", example="2023-11-20T12:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", example="2023-11-20T12:00:00Z")
     *                 ),
     *                 @OA\Property(property="authorization", type="object",
     *                     @OA\Property(property="token", type="string", example="your_jwt_token_here"),
     *                     @OA\Property(property="type", type="string", example="bearer")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error response",
     *         @OA\JsonContent(ref="#/components/schemas/422")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Wrong credentials response",
     *          @OA\JsonContent(ref="#/components/schemas/401")
     *     ),
     * )
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json([
                'user' => $user,
                'authorization' => [
                    'token' => $user->createToken('ApiToken')->plainTextToken,
                    'type' => 'bearer',
                ]
            ]);
        }

        return $this->responseMessage(__('api.auth.invalid_credentials'), 401);
    }
}
