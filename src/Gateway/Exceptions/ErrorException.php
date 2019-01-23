<?php

namespace Roamtech\Gateway\Exceptions;

use Exception;
use Throwable;

class ErrorException extends Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        $message = is_array($message) ? \GuzzleHttp\json_encode($message) : $message;

        parent::__construct($message, $code, $previous);
    }
}
