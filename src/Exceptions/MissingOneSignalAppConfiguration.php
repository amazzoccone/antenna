<?php

namespace Bondacom\antenna\Exceptions;

use Throwable;

class MissingOneSignalAppConfiguration extends AntennaException
{
    public function __construct($appName, $code = 0, Throwable $previous = null)
    {
        parent::__construct('You try to load {$appName} app, but this is not defined in your config file', $code, $previous);
    }
}