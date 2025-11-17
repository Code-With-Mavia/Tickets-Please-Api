<?php

namespace App\Traits;

trait ApiResponses
{
    protected function success($data, string $message, int $statusCode = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    protected function error(string $message, int $statusCode = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $statusCode);
    }

    protected function ok($data = null, string $message = 'OK')
    {
        return $this->success($data, $message, 200);
    }


}
?>
