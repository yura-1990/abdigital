<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseJsonTrait
{
    public function success($data): JsonResponse
    {
        return response()->json($data);
    }

    public function error($errors, string $message = '', int $code = 400): JsonResponse
    {
        return response()->json([
            'errors' => $errors,
            'message' => $message
        ], $code);
    }
}
