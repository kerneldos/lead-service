<?php

namespace App\Exceptions;

class MicroserviceException extends \RuntimeException
{
    public function __construct(
        string $message = "Microservice communication error",
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
