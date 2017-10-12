<?php

namespace Bondacom\antenna\Exceptions;

use Throwable;

class MissingOneSignalAppInformation extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Missing APP ID or APP KEY.', $code, $previous);
    }
}