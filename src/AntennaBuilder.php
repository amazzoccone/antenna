<?php

namespace Bondacom\antenna;

class AntennaBuilder
{
    /**
     * @var ConsumerInterface
     */
    protected $consumer;

    public function __construct()
    {
        $this->consumer = app(ConsumerInterface::class);
    }

    /**
     * @param array $data
     * @return SignalApp
     */
    public function create(array $data)
    {
        $creationResponse = $this->consumer->create($data);
        $app = new SignalApp($creationResponse->id, $creationResponse->basic_auth_key, $creationResponse);

        return $app;
    }
}