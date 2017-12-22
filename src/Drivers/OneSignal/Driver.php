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
     * @param array $data
     * @return array
     */
    public function create($data)
    {
        $this->assertDataCreation($data);

        return $this->requester
            ->setUserKey($this->userKey)
            ->post('apps', $data);
    }

    /**
     * @return array
     */
    public function get()
    {
        $this->assertHasAppData();

        return $this->requester
            ->setUserKey($this->userKey)
            ->get('apps/'.$this->appId);
    }

    /**
     * @param array $data
     * @return array
     */
    public function update($data)
    {
        $this->assertHasAppData();

        return $this->requester
            ->setUserKey($this->userKey)
            ->put('apps/'.$this->appId, $data);
    }

    /**
     * Validate if we have the minimum required data to create an app
     *
     * @param $data
     * @throws MissingOneSignalData
     * @return $this
     */
    private function assertDataCreation($data)
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

        foreach ($fields as $key => $value) {
            if ($value && !array_key_exists($key, $data)) {
                throw new MissingOneSignalData($key);
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