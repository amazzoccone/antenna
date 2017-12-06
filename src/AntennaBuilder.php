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
        $this->oneSignalConsumer = app(OneSignalConsumer::class);
        $this->oneSignalConsumer->setUserKey($userKey);
    }

    /**
     * @param array $data
     *
     * @return SignalApp
     */
    public function create(array $data)
    {
        $creationResponse = $this->oneSignalConsumer->createApp($data);
        $app = new SignalApp($creationResponse->id, $creationResponse->basic_auth_key, $creationResponse);
        $app->setUserKey($this->oneSignalConsumer->getAppKey());

        return $app;
    }
}