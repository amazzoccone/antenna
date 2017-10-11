<?php

namespace Bondacom\antenna;

class SignalApp
{
    /**
     * OneSignal Client
     *
     * @var OneSignalConsumer
     */
    protected $oneSignalConsumer;

    /**
     * Signal constructor.
     *
     * @param $appID string OneSignal APP ID
     * @param $appKey string OneSignal APP Key
     */
    public function __construct($appID, $appKey)
    {
        $this->oneSignalConsumer = app('OneSignalConsumer');
        $this->oneSignalConsumer->setApp($appID, $appKey);
    }
}