<?php

namespace Bondacom\antenna\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Antenna
 * @see \Bondacom\antenna\Antenna
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