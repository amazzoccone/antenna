<?php

namespace Bondacom\Antenna\Models;

class Notification
{
    /**
     * @var string
     */
    protected $appId;

    /**
     * @var
     */
    private $driver;

    /**
     * Notification constructor.
     */
    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param array $parameters
     * @return array
     * @throws AntennaServerException
     */
    public function all(array $parameters = []) : array
    {
        return $this->driver->all($parameters, $this->appId);
    }

    /**
     * @param string $id
     * @return array
     * @throws AntennaServerException
     */
    public function find(string $id) : array
    {
        return $this->driver->find($id, $this->appId);
    }

    /**
     * @param array $data
     * @return array
     * @throws AntennaServerException
     */
    public function create(array $data) : array
    {
        return $this->driver->create($data);
    }

    /**
     * @param string $id
     * @return bool
     * @throws AntennaServerException
     */
    public function cancel(string $id) : bool
    {
        return $this->driver->canel($id, $this->appId);
    }
}