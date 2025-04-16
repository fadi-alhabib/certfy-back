<?php

namespace App\Http\Traits;


trait ApiResponse
{
    protected function ok($message, $data = [])
    {
        return $this->success($message, $data, 200);
    }

    protected function noContent($message = 'No content')
    {
        return $this->success($message, [], 204);
    }

    protected function createdAt($message, $url)
    {
        return $this->success($message, $url, 201);
    }

    protected function success($message, $data, $statusCode = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    protected function error($message, $statusCode)
    {
        return response()->json([
            'message' => $message
        ], $statusCode);
    }
}
