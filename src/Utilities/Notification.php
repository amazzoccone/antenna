<?php

namespace Bondacom\Antenna\Utilities;

use Bondacom\Antenna\Drivers\DriverInterface;

class Notification
{
    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * Notification constructor.
     */
    public function __construct()
    {
        $this->driver = app(DriverInterface::class);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        //
    }

    /**
     * @return
     */
    public function create()
    {
        //
    }

    /**
     * @return boolean
     */
    public function cancel()
    {
        //
    }

    /**
     *
     */
    public function find()
    {
        //
    }
}