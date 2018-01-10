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
     * @return \Bondacom\Antenna\Drivers\AppInterface
     */
    public function newDriverInstance()
    {
        return app(DriverInterface::class)->app();
    }

    /**
     * @return Builder
     */
    public function notification()
    {
        return $this->hasMany(Notification::class, [
            'app_id' => $this->attributes['id']
        ]);
    }
}