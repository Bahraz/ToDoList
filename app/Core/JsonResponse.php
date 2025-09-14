<?php

namespace Bahraz\ToDoApp\Core;

class JsonResponse
{
    public static function success(mixed $data = [],int $code = 200, array $meta = []): void
    {
        http_response_code($code);

        header('Content-Type: application/json');

        $response = [
            'status' => 'success',
            'data' => $data
        ];

        if (!empty($meta)) {
            $response['meta'] = $meta;
        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function error (string $message, int $code = 400): void
    {
        http_response_code($code);

        header('Content-Type: application/json');

        echo json_encode([
            'status' => 'error',
            'message' => $message
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

}   