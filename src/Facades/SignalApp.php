<?php

namespace Bondacom\antenna\Facades;

use Illuminate\Support\Facades\Facade;

class SignalApp extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'SignalApp';
    }
}