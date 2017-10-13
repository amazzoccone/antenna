<?php

namespace Bondacom\antenna\Exceptions;

use Throwable;

class MissingAppRequired extends AntennaException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Missing OneSignal APP ID or APP KEY required for this action.', $code, $previous);
    }
}