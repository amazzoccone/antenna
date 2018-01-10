<?php

namespace Bondacom\Antenna\Models;

use Bondacom\Antenna\Drivers\DriverInterface;
use Bondacom\Antenna\Utilities\Model;

class App extends Model
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
        return new Builder(self::class, $scopes);
    }

    /**
     * @return \Bondacom\Antenna\Drivers\AppInterface
     */
    public static function newDriverInstance()
    {
        return app(DriverInterface::class)->app();
    }
}