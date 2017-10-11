<?php

namespace Bondacom\antenna;

class AntennaBuilder
{
    /**
     * OneSignal Client
     *
     * @var OneSignalConsumer
     */
    protected $oneSignalConsumer;

    /**
     * antennaClass constructor.
     *
     * @param string $userKey One Signal USER AUTH KEY (https://onesignal.com/users/me)
     */
    public function __construct($userKey)
    {
        $this->oneSignalConsumer = app('OneSignalConsumer');
        $this->oneSignalConsumer->setUserKey($userKey);
    }

    /**
     * @return SignalApp
     */
    public function create()
    {

    }
}