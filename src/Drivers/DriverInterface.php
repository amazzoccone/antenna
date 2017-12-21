<?php

namespace Bondacom\Antenna\Drivers;

interface DriverInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function create($data);

    /**
     * @return mixed
     */
    public function get();

    /**
     * @param $data
     * @return mixed
     */
    public function update($data);
}