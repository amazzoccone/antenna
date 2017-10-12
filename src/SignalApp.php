<?php

namespace Bondacom\antenna;

class SignalApp extends AntennaModel
{
    /**
     * OneSignal Client
     *
     * @var OneSignalConsumer
     */
    protected $oneSignalConsumer;

    /**
     * Object name in OneSignal system (Generally, the name of the endpoint)
     *
     * @var string
     */
    protected $oneSignalObject = 'apps';

    /**
     * Signal constructor.
     *
     * @param string $appID OneSignal APP ID
     * @param string $appKey OneSignal APP Key
     * @param string $userKey If you want edit and save app, you will need UserKey. This is a optional parameter.
     * @param array $metaData If you have all the information, can send metadata in order to avoid make a new call. This is a optional parameter.
     */
    public function __construct($appID, $appKey, $metaData = [])
    {
        $this->oneSignalConsumer = app(OneSignalConsumer::class);
        $this->oneSignalConsumer->setApp($appID, $appKey);

        $this->loadFromMetadata($metaData);
    }

    /**
     * Set user key (In order to update app, for example)
     *
     * @param $key
     *
     * @return $this
     */
    public function setUserKey($key)
    {
        $this->oneSignalConsumer->setUserKey($key);
        return $this;
    }
}