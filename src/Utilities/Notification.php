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
     * @param array $parameters
     * @return \Illuminate\Support\Collection
     */
    public function all(array $parameters = [])
    {
        $data = $this->driver->all($parameters);
        return collect($data);
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