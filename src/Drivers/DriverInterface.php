<?php

namespace Bondacom\Antenna\Drivers;

interface DriverInterface
{
    /**
     * @param string $key
     * @return $this
     */
    public function setUserKey(string $key);

    /**
     * @return \Bondacom\Antenna\Drivers\AppInterface
     */
    public function app();

    /**
     * @return \Bondacom\Antenna\Drivers\NotificationInterface
     */
    public function notification();
}