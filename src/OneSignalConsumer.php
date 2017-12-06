<?php

namespace Bondacom\antenna;

use Bondacom\antenna\Exceptions\MissingOneSignalData;
use Bondacom\antenna\Exceptions\MissingUserKeyRequired;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class OneSignalConsumer
{

    /**
     * One Signal Base URL
     * @var string
     */
    const BASE_URL = 'https://onesignal.com/api/';

    /**
     * One Signal Api version
     *
     * @var string
     */
    const API_VERSION = 'v1';

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
     * HTTP to send Headers
     *
     * @var array
     */
    protected $headers = [];
    /**
     * @var AntennaRequester
     */
    private $requester;

    /**
     * OneSignalConsumer constructor.
     * @param AntennaRequester $requester
     */
    public function __construct(AntennaRequester $requester)
    {
        $this->requester = $requester;
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
     * Get user key value
     *
     * @return string
     */
    public function getUserKey()
    {
        return $this->userKey;
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

    /**
     * Get app id value
     *
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * Get app key value
     *
     * @return string
     */
    public function getAppKey()
    {
        return $this->appKey;
    }

//**********************************
//          APP ENDPOINTS
//**********************************

    /**
     * Creates a new OneSignal APP.
     *
     * @param array $data Data APP
     *
     * @return Object
     */
    public function createApp($data)
    {
        // For references about the fields go to https://documentation.onesignal.com/reference#create-an-app
        $fields = [
            //App name, REQUIRED
            'name' => true,

            // IOS Configuration
            'apns_env' => false,
            'apns_p12' => false,
            'apns_p12_password' => false,

            // Android Configuration
            'gcm_key' => false,
            'android_gcm_sender_id' => false,

            // Web notifications (Chrome and Firefox)
            'chrome_web_origin' => false,
            'chrome_web_default_notification_icon' => false,
            'chrome_web_sub_domain' => false,

            // Web notifications (Safari)
            'safari_apns_p12' => false,
            'safari_apns_p12_password' => false,
            'site_name' => false,
            'safari_site_origin' => false,
            'safari_icon_256_256' => false,

            //Chrome extension
            'chrome_key' => false
        ];

        $this->assertData($fields, $data)
            ->addUserKey();

        return $this->requester->post('apps', $data);
    }

    /**
     * Creates a new OneSignal APP.
     *
     * @return Object
     */
    public function getApp()
    {
        $this->assertHasAppData()
            ->addUserKey();

        return $this->requester->get('apps/'.$this->appId);
    }

    /**
     * Creates a new OneSignal APP.
     *
     * @param array $data Data APP
     *
     * @return Object
     */
    public function updateApp($data)
    {
        $this->assertHasAppData()
            ->addUserKey();

        return $this->requester->put('apps/'.$this->appId, $data);
    }
    
    /**
     * Checks if User Key is set.
     *
     * If there is not a user key this method will throw an exception.
     *
     * If is there, then, will add the proper header
     *
     * @throws MissingUserKeyRequired
     *
     * @return $this
     */
    public function addUserKey()
    {
        if (!$this->userKey) {
            throw new MissingUserKeyRequired();
        }

        $this->headers['headers']['Authorization'] = 'Basic ' . $this->userKey;

        return $this;
    }

    /**
     * Check if app is load.
     *
     * If there is not a app this method will throw an exception.
     *
     * If is there, then, will add the proper header
     *
     * @throws MissingUserKeyRequired
     *
     * @return $this
     */
    public function addAppKey()
    {
        if (!$this->appId || !$this->appKey) {
            throw new MissingUserKeyRequired();
        }

        $this->headers['headers']['Authorization'] = 'Basic ' . $this->appKey;

        return $this;
    }

    /**
     * Validate if we have the minimum required data
     *
     * @param $fields
     * @param $data
     *
     * @throws MissingOneSignalData
     * @return $this
     */
    private function assertData($fields, $data)
    {
        foreach ($fields AS $param => $required) {
            if ($required && !array_key_exists($param, $data)) {
                throw new MissingOneSignalData($param);
            }
        }

        return $this;
    }

    /**
     * Sometimes, you need app data (For example app id in getApp function) but you don't want add appKey.
     *
     * In this moment you can use this method.
     *
     * @throws MissingUserKeyRequired
     * @return $this
     */
    public function assertHasAppData()
    {
        if (!$this->appId || !$this->appKey) {
            throw new MissingUserKeyRequired();
        }

        return $this;
    }
}