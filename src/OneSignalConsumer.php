<?php

namespace Bondacom\antenna;

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
     * OneSignalConsumer constructor.
     */
    function __construct()
    {

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
}