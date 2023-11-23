<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

trait ApiResponsable
{
    /**
     * Returns a JSON response containing the provided message.
     *
     * @param string $message The message to be displayed
     * @param int $code The HTTP status code for the response
     * @return JsonResponse The formatted JSON response
     */
    protected function responseMessage(string $message, int $code = 200): JsonResponse
    {
        return response()->json(['message' => $message], $code);
    }
}
