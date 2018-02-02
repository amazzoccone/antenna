<?php

namespace Bondacom\Antenna\Drivers;

interface ModelInterface
{
    /**
     * @param array $parameters
     * @return array
     * @throws AntennaServerException
     * TODO: Return a Collection instead of array
     */
    public function all(array $parameters = []) : array;

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
    public function find(string $id) : array;

    /**
     * @param array $data
     * @param string $id
     * @return array
     * @throws AntennaServerException
     */
    public function update(array $data, string $id) : array;

    /**
     * @param string $id
     * @return bool
     * @throws AntennaServerException
     */
    public function delete(string $id) : bool;

    /**
     * @param array $parameters
     * @return $this
     */
    public function append(array $parameters);
}