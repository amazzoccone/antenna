<?php

namespace Bondacom\Antenna\Exceptions;

use Throwable;

class AntennaMethodNotExistsException extends AntennaException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}