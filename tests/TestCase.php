<?php

namespace Bondacom\Antenna\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $mockRequester;

    /**
     * @param $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Bondacom\Antenna\Providers\AntennaServiceProvider::class
        ];
    }

    /**
     * @param $class
     * @param array $arguments
     * @return \Mockery\MockInterface
     */
    public function mock($class, array $arguments = null)
    {
        $mock = $arguments ? \Mockery::mock($class, $arguments) : \Mockery::mock($class);
        $this->app->instance($class, $mock);
        return $mock;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function fakeRequesterData(array $data = [])
    {
        $id = random_int(1, 9999);
        $name = 'Testing';
        $basic_auth_key = str_random();
        $fakeData = compact('id', 'name', 'basic_auth_key');

        return array_merge($fakeData, $data);
    }
}
