<?php

namespace Bondacom\Antenna\Models;

use Bondacom\Antenna\Utilities\Model;

class Notification extends Model
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @return \Bondacom\Antenna\Drivers\NotificationInterface
     */
    public function newDriverInstance()
    {
        return app(DriverInterface::class)->notification();
    }
}