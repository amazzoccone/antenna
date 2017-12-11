<?php

namespace Bondacom\antenna;

class AntennaBuilder
{
    /**
     * @var ConsumerInterface
     */
    protected $consumer;

    /**
     * @param string $userKey
     */
    public function __construct($userKey)
    {
        $this->consumer = app(OneSignalConsumer::class);
        $this->consumer->setUserKey($userKey);
    }

    /**
     * @param array $data
     * @return SignalApp
     */
    public function create(array $data)
    {
        $creationResponse = $this->consumer->create($data);
        $app = new SignalApp($creationResponse->id, $creationResponse->basic_auth_key, $creationResponse);
        $app->setUserKey($this->consumer->getAppKey());

        return $app;
    }
}