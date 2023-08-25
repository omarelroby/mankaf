<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait Response
{
    /**
     * Returns the success response with custom data and status
     *
     * @param array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function success(array $data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => !empty($data) ? $data : (object) []
        ], $status);
    }

    /**
     * Returns the error response with custom data and status
     *
     * @param string $message
     * @param array $data
     * @param integer $status
     * @return JsonResponse
     */
    public function error(string $message = '', array $data = [], int $status = 500): JsonResponse
    {
        $data = ($data) ? $data : (object) [];
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function successMessage(string $message = '', array $data = [], int $status = 200): JsonResponse
    {
        $data = ($data) ? $data : (object) [];
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

}
