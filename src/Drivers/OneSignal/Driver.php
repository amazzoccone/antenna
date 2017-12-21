<?php

namespace Bondacom\Antenna\Drivers\OneSignal;

use Bondacom\Antenna\Drivers\DriverInterface;
use Bondacom\Antenna\Exceptions\MissingOneSignalAppInformation;
use Bondacom\Antenna\Exceptions\MissingOneSignalData;

class Driver implements DriverInterface
{
    /**
     * OneSignal USER AUTH KEY (https://onesignal.com/users/me)
     *
     * @var string
     */
    protected $userKey = null;

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
     * @var AntennaRequester
     */
    private $requester;

    /**
     * OneSignalConsumer constructor.
     * @param Requester $requester
     */
    public function __construct(Requester $requester)
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

    /**
     * Creates a new OneSignal APP.
     *
     * @param array $data Data APP
     *
     * @return Object
     */
    public function create($data)
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

        $this->assertData($fields, $data);

        return $this->requester
            ->setUserKey($this->userKey)
            ->post('apps', $data);
    }

    /**
     * Get an specified OneSignal APP.
     *
     * @return Object
     */
    public function get()
    {
        $this->assertHasAppData();

        return $this->requester
            ->setUserKey($this->userKey)
            ->get('apps/'.$this->appId);
    }

    /**
     * Updates OneSignal APP.
     *
     * @param array $data Data APP
     *
     * @return Object
     */
    public function update($data)
    {
        $this->assertHasAppData();

        return $this->requester
            ->setUserKey($this->userKey)
            ->put('apps/'.$this->appId, $data);
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
     * @return $this
     * @throws MissingOneSignalAppInformation
     */
    private function assertHasAppData()
    {
        if (!$this->appId || !$this->appKey) {
            throw new MissingOneSignalAppInformation();
        }

        return $this;
    }
}