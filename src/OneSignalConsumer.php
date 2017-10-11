<?php

namespace Bondacom\antenna;

use Bondacom\antenna\Exceptions\MissingUserKeyRequired;
use GuzzleHttp\Client;

class OneSignalConsumer
{

    /**
     * One Signal Base URL
     * @var string
     */
    protected $baseUrl = 'https://onesignal.com/api/';

    /**
     * One Signal Api version
     *
     * @var string
     */
    protected $version = 'v1';

    /**
     * OneSignal USER AUTH KEY (https://onesignal.com/users/me)
     *
     * @var string
     */
    protected $userKey = false;

    /**
     * One Signal App ID
     *
     * @var string
     */
    protected $appId = false;

    /**
     * One Signal App Key
     *
     * @var string
     */
    protected $appKey = false;

    /**
     * Guzzle Client
     *
     * @var Client
     */
    protected $guzzleClient;

    /**
     * OneSignalConsumer constructor.
     *
     * @param Client $guzzleClient
     */
    function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * Set user key
     *
     * @param $userKey string One Signal User Key
     *
     * @return $this
     */
    public function setUserKey($userKey)
    {
        $this->userKey = $userKey;
        return $this;
    }

    /**
     * Set One Signal App
     *
     * @param $appId string App ID
     * @param $appKey string App Key
     *
     * @return $this
     */
    public function setApp($appId, $appKey)
    {
        $this->appId = $appId;
        $this->appKey = $appKey;
        return $this;
    }

    public function createApp()
    {
        $fields = [
            'name',
            'apns_env',
            'apns_p12',
            'apns_p12_password',
            'gcm_key',
            'android_gcm_sender_id',
            'chrome_web_origin',
            'chrome_web_default_notification_icon',
            'chrome_web_sub_domain',
            'safari_apns_p12',
            'safari_apns_p12_password',
            'site_name',
            'safari_site_origin',
            'safari_icon_256_256',
            'chrome_key'
        ];
        $this->assertHasUserKey();

    }

    /**
     * Check if User Key is set.
     *
     * If there is not a user key this method will throw an exception.
     *
     * @throws MissingUserKeyRequired
     */
    public function assertHasUserKey()
    {
        if(!$this->userKey)
        {
            throw new MissingUserKeyRequired();
        }
    }

}