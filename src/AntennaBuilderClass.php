<?php

namespace Bondacom\antenna;

class AntennaBuilder
{
    /**
     * @var string
     */
    protected $userKey;

    /**
     * antennaClass constructor.
     *
     * @param string $userKey One Signal USER AUTH KEY (https://onesignal.com/users/me)
     */
    public function __construct($userKey)
    {
        $this->userKey = $userKey;
    }
}