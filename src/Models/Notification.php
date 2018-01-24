<?php

namespace Bondacom\Antenna\Models;

use Bondacom\Antenna\Drivers\DriverInterface;
use Bondacom\Antenna\Utilities\Model;

class Notification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'successful',
        'failed',
        'converted',
        'remaining',
        'queued_at',
        'send_after',
        'url',
        'data',
        'canceled',
        'headings',
        'contents',
    ];

    /**
     * @return \Bondacom\Antenna\Drivers\NotificationInterface
     */
    public function newDriverInstance()
    {
        return app(DriverInterface::class)->notification();
    }
}