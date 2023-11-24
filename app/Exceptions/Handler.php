<?php

namespace App\Exceptions;

use App\Traits\ApiResponsableTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponsableTrait;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse
    {
        if ($e instanceof AuthorizationException) {
            return $this->responseMessage($e->getMessage(), 403);
        }
        if ($e instanceof ModelNotFoundException && $request->expectsJson()) {
            return $this->responseMessage(str_replace('App\\Models\\', '', $e->getMessage()), 404);
        }
        if ($e instanceof NotFoundHttpException && $request->expectsJson()) {
            return $this->responseMessage($e->getMessage(), 404);
        }

        return parent::render($request, $e);
    }
}
