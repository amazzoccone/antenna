<?php

namespace Bondacom\Antenna\Drivers;

interface DriverInterface
{
    /**
     * DriverInterface constructor.
     * @param string $key
     */
    public function __construct(string $key);

    /**
     * @return \Bondacom\Antenna\Drivers\AppInterface
     */
    public function app();

    /**
     * @return \Bondacom\Antenna\Drivers\NotificationInterface
     */
    public function notification();
}