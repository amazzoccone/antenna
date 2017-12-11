<?php

namespace Bondacom\antenna;

interface ConsumerInterface
{
    /**
     * @param $userKey
     * @return mixed
     */
    public function setUserKey($userKey);

    /**
     * @param $data
     * @return mixed
     */
    public function createApp($data);

    /**
     * @return mixed
     */
    public function getApp();

    /**
     * @param $data
     * @return mixed
     */
    public function updateApp($data);
}