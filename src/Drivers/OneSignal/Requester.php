<?php

namespace Bondacom\Antenna\Drivers\OneSignal;

use Bondacom\Antenna\Exceptions\MissingUserKeyRequired;
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

    /**
     * @param string $key
     * @return $this
     * @throws MissingUserKeyRequired
     */
    public function setUserKey($key)
    {
        if (empty($key)) {
            throw new MissingUserKeyRequired();
        }

        $this->headers['headers']['Authorization'] = 'Basic ' . $key;

        return $this;
    }
}