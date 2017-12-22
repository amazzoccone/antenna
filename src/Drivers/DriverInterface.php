<?php

namespace Bondacom\Antenna\Drivers;

interface DriverInterface
{
    /**
     * @param $data
     * @return array
     */
    public function create($data);

    /**
     * @return array
     */
    public function get();

    /**
     * @param $data
     * @return array
     */
    public function update($data);
}