<?php

namespace app\components\prices_api;

class ApiResponse
{
    /**
     * @var bool
     */
    public $isSuccess;
    /**
     * @var string
     */
    public $errorMessage;
    /**
     * @var array|null
     */
    public $data;

    public function __construct(
        bool $isSuccess,
        string $errorMessage,
        ?array $data
    )
    {
        $this->isSuccess = $isSuccess;
        $this->errorMessage = $errorMessage;
        $this->data = $data;
    }
}