<?php

namespace Bondacom\Antenna;

interface ConsumerInterface
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