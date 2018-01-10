<?php

namespace Bondacom\Antenna\Models;

use Bondacom\Antenna\Drivers\DriverInterface;

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
     * @return \Bondacom\Antenna\Drivers\AppInterface
     */
    public static function newDriverInstance()
    {
        return app(DriverInterface::class)->app();
    }
}