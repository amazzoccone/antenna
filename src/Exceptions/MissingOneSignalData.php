<?php

namespace Bondacom\Antenna\Exceptions;

use Throwable;

class MissingOneSignalData extends AntennaException
{
    public function __construct($missed = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('You must set '.$missed.' for this action.', $code, $previous);
    }
}