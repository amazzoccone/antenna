<?php

namespace Bondacom\antenna\Tests;

use Bondacom\antenna\AntennaRequester;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->mockRequester();
    }

    /**
     * @param $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Bondacom\antenna\Providers\AntennaServiceProvider::class
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
     * @return $this
     */
    private function mockRequester()
    {
        $obj = new \stdClass();
        $obj->id = random_int(1, 9999);
        $obj->name = 'Testing';
        $obj->basic_auth_key = str_random();

        $mock = $this->mock(AntennaRequester::class)->makePartial();
        $mock->shouldReceive('get')->andReturn($obj);
        $mock->shouldReceive('put')->andReturn($obj);
        $mock->shouldReceive('post')->andReturn($obj);
        $mock->shouldReceive('setUserKey')->andReturnSelf();

        return $this;
    }
}
