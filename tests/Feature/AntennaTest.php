<?php

namespace Bondacom\Antenna\Tests\Feature;

use Bondacom\Antenna\Drivers\OneSignal\Requester;
use Bondacom\Antenna\Facades\Antenna;
use Bondacom\Antenna\Models\App;
use Bondacom\Antenna\Tests\TestCase;

class AntennaTest extends TestCase
{
    /**
     * @test
     */
    public function app_method_returns_the_default_config_app()
    {
        $data = $this->fakeRequesterData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andReturn($data);

        $app = Antenna::app();

        $this->assertInstanceOf(App::class, $app);
    }

    /**
     * @test
     */
    public function app_method_returns_a_config_app()
    {
        $data = $this->fakeRequesterData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andReturn($data);

        $app = Antenna::app('default');

        $this->assertInstanceOf(App::class, $app);
    }

    /**
     * @test
     */
    public function app_method_returns_a_custom_config_app()
    {
        $data = $this->fakeRequesterData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andReturn($data);

        $app = Antenna::app([
            'id' => random_int(1, 99999),
            'key' => str_random()
        ]);

        $this->assertInstanceOf(App::class, $app);
    }

    /**
     * @test
     */
    public function it_creates_an_app()
    {
        $data = $this->fakeRequesterData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('post')->once()->andReturn($data);

        $app = Antenna::create([
            'name' => 'Testing One Signal Application',
            'chrome_web_origin' => 'https://example.com',
        ]);

        $this->assertInstanceOf(App::class, $app);
    }
}
