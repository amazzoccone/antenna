<?php

namespace Bondacom\antenna\Exceptions;

use Throwable;

class MissingUserKeyRequired extends AntennaException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Missing OneSignal UserKey required for this action.', $code, $previous);
    }
}