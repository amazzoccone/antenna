<?php

namespace Bondacom\Antenna;

use Bondacom\Antenna\Drivers\DriverInterface;
use Bondacom\Antenna\Models\Notification;

class App
{
    /**
     * @var array
     */
    protected $attributes = [
        'id' => null
    ];

    /**
     * @return Notification
     */
    public function notification()
    {
        return new Notification($this->attributes['id']);
    }

    /**
     * @return DriverInterface
     */
    public function newDriverInstance()
    {
        return app(DriverInterface::class)->app();
    }
}