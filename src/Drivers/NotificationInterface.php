<?php

namespace Bondacom\Antenna\Drivers;

interface NotificationInterface
{
    //TODO: Create ModelInteface for common methods

    /**
     * @param array $parameters
     * @param string $appId
     * @return array
     * @throws AntennaServerException
     */
    public function all(array $parameters = [], string $appId) : array;

    /**
     * @param string $id
     * @param string $appId
     * @return array
     * @throws AntennaServerException
     */
    public function find(string $id, string $appId) : array;

    /**
     * @param array $data
     * @return array
     * @throws AntennaServerException
     */
    public function create(array $data) : array;

    /**
     * @param string $id
     * @param string $appId
     * @return bool
     * @throws AntennaServerException
     */
    public function cancel(string $id, string $appId) : bool;
}