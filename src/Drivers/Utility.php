<?php

namespace Bondacom\Antenna\Drivers;

use Bondacom\Antenna\Drivers\OneSignal\Requester;
use Bondacom\Antenna\Exceptions\AntennaMethodNotExistsException;
use Bondacom\Antenna\Exceptions\AntennaServerException;

abstract class Utility
{
    /**
     * @var Requester
     */
    protected $requester;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * Utility constructor.
     * @param Requester $requester
     */
    public function __construct(Requester $requester)
    {
        $this->requester = $requester;
    }

    /**
     * @return Requester
     */
    public function requester()
    {
        return $this->requester;
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function append(array $parameters)
    {
        $this->parameters = array_merge($this->parameters, $parameters);
        return $this;
    }

    /**
     * @param $result
     * @return $this
     * @throws AntennaServerException
     */
    protected function assertHasNotErrors($result)
    {
        if ($this->hasErrors($result)) {
            throw new AntennaServerException(implode(', ', $result['errors']));
        }

        return $this;
    }

    /**
     * @param $result
     * @return bool
     */
    protected function hasErrors($result)
    {
        return array_key_exists('errors', $result);
    }

    /**
     * @throws AntennaMethodNotExistsException
     */
    protected function notImplemented()
    {
        throw new AntennaMethodNotExistsException();
    }

    /**
     * @return array
     */
    protected function result($response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}