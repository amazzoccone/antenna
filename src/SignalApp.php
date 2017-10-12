<?php

namespace Bondacom\antenna;

class SignalApp extends AntennaModel
{
    /**
     * Object name in OneSignal system (Generally, the name of the endpoint)
     *
     * @var string
     */
    protected $oneSignalObject = 'App';

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
        $oneSignalConsumer = app(OneSignalConsumer::class);
        $oneSignalConsumer->setApp($appID, $appKey);
        parent::__construct($oneSignalConsumer);

        $this->id = $appID;
        $this->basic_auth_key = $appKey;
        $this->loadFromMetadata($metaData);
    }

    public function show()
    {
        return $this;
    }
}