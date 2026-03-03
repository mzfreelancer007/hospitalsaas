<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (ModelNotFoundException $e, $request) {
            return response()->json([
                'success' => false,
                'data' => null,
                'error' => ['code' => 'NOT_FOUND', 'message' => 'Resource not found.', 'details' => null],
            ], 404);
        });

        $this->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'success' => false,
                'data' => null,
                'error' => ['code' => 'VALIDATION_ERROR', 'message' => 'Validation failed.', 'details' => $e->errors()],
            ], 422);
        });

        $this->renderable(function (AuthorizationException $e, $request) {
            return response()->json([
                'success' => false,
                'data' => null,
                'error' => ['code' => 'FORBIDDEN', 'message' => $e->getMessage(), 'details' => null],
            ], 403);
        });
    }
}
