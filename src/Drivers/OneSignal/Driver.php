<?php

namespace Bondacom\Antenna\Drivers\OneSignal;

use Bondacom\Antenna\Drivers\DriverInterface;

class Driver implements DriverInterface
{
    /**
     * @var \Bondacom\Antenna\Drivers\AppInterface
     */
    private $app;

    /**
     * @var \Bondacom\Antenna\Drivers\NotificationInterface
     */
    private $notification;

    /**
     * Driver constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $requester = app(Requester::class);
        $requester->setUserKey($key);

        $this->app = new App($requester);
        $this->notification = new Notification($requester);
    }

    /**
     * @return \Bondacom\Antenna\Drivers\AppInterface
     */
    public function app()
    {
        return $this->app;
    }

    /**
     * @return \Bondacom\Antenna\Drivers\NotificationInterface
     */
    public function notification()
    {
        return $this->notification;
    }
}