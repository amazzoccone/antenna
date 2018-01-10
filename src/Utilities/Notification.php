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
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        //
    }

    /**
     * @param string $id
     * @return boolean
     */
    public function cancel(string $id)
    {
        //
    }

    /**
     * @param array $data
     * @param string $id
     * @return array
     */
    public function update(array $data, string $id)
    {
        //
    }
}