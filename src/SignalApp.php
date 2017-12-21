<?php

namespace Bondacom\antenna;

use Bondacom\antenna\Exceptions\MissingOneSignalAppConfiguration;
use Bondacom\antenna\Exceptions\MissingOneSignalAppInformation;

class SignalApp extends AntennaModel
{
    /**
     * Signal constructor.
     *
     * @param string $appID OneSignal APP ID
     * @param string $appKey OneSignal APP Key
     * @param array $metaData If you have all the information, can send metadata in order to avoid make a new call. This is a optional parameter.
     */
    public function __construct($appID, $appKey, $metaData = [])
    {
        $consumer = app(OneSignalConsumer::class);
        $consumer->setApp($appID, $appKey);
        parent::__construct($consumer);

        $this->id = $appID;
        $this->basic_auth_key = $appKey;
        $this->loadFromMetadata($metaData);
    }

    /**
     * @param $what
     * @return $this|SignalApp
     * @throws MissingOneSignalAppConfiguration
     * @throws MissingOneSignalAppInformation
     */
    public function get($what = false)
    {
        //TODO: Why someone would use get() to return $this ?!
        if (!$what) {
            return $this;
        }

        $config = config('antenna');

        if (is_array($what)) {
            if (!isset($what['id']) OR !isset($what['key'])) {
                throw new MissingOneSignalAppInformation();
            }

            $signalApp = new SignalApp($what['id'], $what['key']);
            return $signalApp;
        }

        if (is_string($what)) {
            if (!isset($config['apps'][$what])) {
                throw new MissingOneSignalAppConfiguration($what);
            }

            //TODO: Always get default App ?!
            $app = $config['apps'][$config['default_app']];
            $signalApp = new SignalApp($app['id'], $app['key']);
            return $signalApp;
        }
    }
}