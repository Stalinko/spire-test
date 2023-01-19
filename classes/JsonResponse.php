<?php

use JetBrains\PhpStorm\NoReturn;

class JsonResponse
{
    public const STATUS_OK = 200;
    public const STATUS_INVALID_INPUT = 400;
    public const STATUS_ERROR = 500;

    public function __construct(
        private readonly mixed $data,
        private readonly int $status = 200
    )
    {
    }

    #[NoReturn]
    public function outputAndTerminate(): void
    {
        if ($this->status !== self::STATUS_OK) {
            http_response_code($this->status);
        }

        header('Content-Type: application/json');
        echo json_encode($this->data);
        exit;
    }
}