<?php

namespace Bondacom\Antenna\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Antenna
 * @see \Bondacom\Antenna\Antenna
 *
 */
class Antenna extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Antenna';
    }
}