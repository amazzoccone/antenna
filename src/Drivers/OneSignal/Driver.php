<?php

namespace Bondacom\Antenna\Drivers\OneSignal;

use Bondacom\Antenna\Drivers\DriverInterface;
use Bondacom\Antenna\Drivers\AppInterface;
use Bondacom\Antenna\Drivers\NotificationInterface;

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

        $this->app = new App($requester);
        $this->app->requester()->setAuthorizationKey($key);
        $this->notification = new Notification($requester);
    }

    /**
     * @return \Bondacom\Antenna\Drivers\AppInterface
     */
    public function app() : AppInterface
    {
        return $this->app;
    }

    /**
     * @return \Bondacom\Antenna\Drivers\NotificationInterface
     */
    public function notification(): NotificationInterface
    {
        return $this->notification;
    }
}