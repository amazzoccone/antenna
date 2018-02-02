<?php

namespace Bondacom\Antenna\Models;

use Bondacom\Antenna\Drivers\DriverInterface;
use Bondacom\Antenna\Utilities\Model;

class App extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'players',
        'messageable_players',
        'updated_at',
        'created_at',
        'gcm_key',
        'chrome_key',
        'chrome_web_origin',
        'chrome_web_gcm_sender_id',
        'chrome_web_default_notification_icon',
        'chrome_web_sub_domain',
        'apns_env',
        'apns_certificates',
        'safari_apns_certificate',
        'safari_site_origin',
        'safari_push_id',
        'safari_icon_16_16',
        'safari_icon_32_32',
        'safari_icon_64_64',
        'safari_icon_128_128',
        'safari_icon_256_256',
        'site_name',
        'basic_auth_key',
    ];

    /**
     * @return \Bondacom\Antenna\Drivers\AppInterface
     */
    public function newDriverInstance()
    {
        return app(DriverInterface::class)->app();
    }

    /**
     * @return Builder
     */
    public function notification()
    {
        return $this->newQuery(Notification::class)->append([
            'app_id' => $this->attributes['id'],
            'app_key' => $this->attributes['basic_auth_key'],
        ]);
    }
}