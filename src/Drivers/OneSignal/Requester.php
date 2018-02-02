<?php

namespace Bondacom\Antenna\Drivers\OneSignal;

use Bondacom\Antenna\Drivers\Requester as Base;

class Requester extends Base
{
    /**
     * @return string
     */
    protected function url() : string
    {
        return 'https://onesignal.com/api/v1';
    }
}