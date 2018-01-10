<?php

namespace Bondacom\Antenna\Drivers;

interface NotificationInterface
{
    /**
     * @param array $parameters
     * @return array
     * @throws AntennaServerException
     */
    public function all(array $parameters = []) : array;

    /**
     * @param string $id
     * @return array
     * @throws AntennaServerException
     */
    public function find(string $id) : array;

    /**
     * @param array $data
     * @return array
     * @throws AntennaServerException
     */
    public function create(array $data) : array;

    /**
     * @param string $id
     * @return array
     * @throws AntennaServerException
     */
    public function cancel(string $id) : array;
}