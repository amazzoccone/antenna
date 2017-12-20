<?php

namespace Bondacom\antenna\Tests;

use Bondacom\antenna\Facades\AntennaBuilder;
use Bondacom\antenna\OneSignalConsumer;
use Bondacom\antenna\SignalApp;

class SignalAppTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_a_one_signal_model_successfully()
    {
        $obj = new \stdClass();
        $obj->id = random_int(1, 9999);
        $obj->basic_auth_key = str_random();

        $mock = $this->mock(OneSignalConsumer::class);
        $mock->shouldReceive('createApp')
            ->once()
            ->andReturn($obj);
        $mock->shouldReceive('setApp')
            ->once();
        $mock->shouldReceive('setUserKey')
            ->twice();
        $mock->shouldReceive('getAppKey')
            ->once()
            ->andReturn(str_random());

        $app = AntennaBuilder::create([
            'name' => 'Testing One Signal Application',
            'chrome_web_origin' => 'https://example.com',
        ]);

        $this->assertInstanceOf(SignalApp::class, $app);
    }
}
