<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    public int $status;

    public function __construct(string $message, int $status = 422)
    {
        parent::__construct($message);
        $this->status = $status;
    }
}
