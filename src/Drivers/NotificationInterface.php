<?php

namespace Bondacom\Antenna\Drivers;

interface NotificationInterface
{
    /**
     * @param array $parameters
     * @return array
     */
    public function all(array $parameters = []);

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data);

    /**
     * @param string $id
     * @return array
     */
    public function cancel(string $id);

    /**
     * @param array $data
     * @param string $id
     * @return array
     */
    public function update(array $data, string $id);
}