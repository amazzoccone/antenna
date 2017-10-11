<?php

namespace Bondacom\antenna\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class AntennaBuilder
 * @see \Bondacom\antenna\AntennaBuilder
 *
 */
class AntennaBuilder extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'AntennaBuilder';
    }
}