<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    protected function success($data = null, int $status = 200): JsonResponse
    {
        return response()->json(['success' => true, 'data' => $data, 'error' => null], $status);
    }

    protected function error(string $code, string $message, $details = null, int $status = 400): JsonResponse
    {
        return response()->json(['success' => false, 'data' => null, 'error' => compact('code', 'message', 'details')], $status);
    }
}
