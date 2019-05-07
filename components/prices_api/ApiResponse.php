<?php

namespace app\components\prices_api;

class ApiResponse
{
    /**
     * @var bool
     */
    public $isSuccess;
    /**
     * @var array|null
     */
    public $data;

    public function __construct(
        bool $isSuccess,
        ?array $data
    )
    {
        $this->isSuccess = $isSuccess;
        $this->data = $data;
    }
}