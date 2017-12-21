<?php

namespace Bondacom\antenna;

class Antenna 
{
    /**
     * @var array
     */
    private $config;

    /**
     * Antenna constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param string|array $config
     * @return AntennaModel
     */
    public function app($config = null)
    {
        $config = $this->config($config);

        return AntennaModel::find($config['id'], $config['key']);
    }

    /**
     * @param array $data
     * @return SignalApp
     */
    public function create(array $data)
    {
        return AntennaModel::create($data);
    }

    /**
     * @param $config
     * @return array
     */
    private function config($config)
    {
        if (is_null($config)) {
            return $this->config['default_app'];
        }

        return is_string($config) ? $this->config['apps'][$config] : $config;
    }
}