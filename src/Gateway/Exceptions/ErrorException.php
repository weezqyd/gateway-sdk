<?php

namespace Roamtech\Gateway\Exceptions;

use Exception;
use Throwable;

class ErrorException extends Exception
{
    public function __construct(array $message, int $code = 0, Throwable $previous = null)
    {
        $message = \GuzzleHttp\json_encode($message);

        parent::__construct($message, $code, $previous);
    }
}
