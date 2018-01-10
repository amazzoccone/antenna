<?php

namespace Bondacom\Antenna\Drivers;

interface AppInterface
{
    /**
     * @param array $data
     * @return array
     */
    public function create(array $data);

    /**
     * @param string $id
     * @return array
     */
    public function find(string $id);

    /**
     * @param array $data
     * @param string $id
     * @return array
     */
    public function update(array $data, string $id);
}