<?php

namespace Bondacom\Antenna\Models;

class Notification
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @param array $parameters
     * @return array
     * @throws AntennaServerException
     */
    public function all(array $parameters = []) : array
    {
        //TODO: Move this to Model
        return $this->driver->all($parameters, $this->appId);
    }

    /**
     * @param string $id
     * @return array
     * @throws AntennaServerException
     */
    public function find(string $id) : array
    {
        //TODO: Move this to Model. find() should accept common parameters like a global scope
        return $this->driver->find($id, $this->appId);
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