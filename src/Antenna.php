<?php

namespace Bondacom\Antenna;

use Bondacom\Antenna\Models\App;

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
     * @return App
     */
    public function app($config = null)
    {
        $creds = $this->config($config);

        return App::find($creds['id']);
    }

    /**
     * @param array $data
     * @return App
     */
    public function create(array $data)
    {
        return App::create($data);
    }

    /**
     * @param $config
     * @return array
     */
    private function config($config)
    {
        if (is_null($config)) {
            $config = $this->config['default_app'];
        }

        return is_string($config) ? $this->config['apps'][$config] : $config;
    }
}