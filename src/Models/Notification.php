<?php

namespace Bondacom\Antenna\Models;

class Notification
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @return \Bondacom\Antenna\Drivers\NotificationInterface
     */
    public static function newDriverInstance()
    {
        return app(DriverInterface::class)->notification();
    }

    /**
     * @param string $id
     * @return bool
     * @throws AntennaServerException
     */
    public function cancel(string $id) : bool
    {
        return $this->driver->delete($id);
    }

    /**
     * @return array
     */
    protected function scope()
    {
        return [
            'app_id' => $this->attributes['app_id']
        ];
    }
}