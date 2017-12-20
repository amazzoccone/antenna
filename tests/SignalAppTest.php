<?php

namespace Bondacom\antenna\Tests;

use Bondacom\antenna\Facades\SignalApp;
use Bondacom\antenna\OneSignalConsumer;

class SignalAppTest extends TestCase
{
    /**
     * @test
     */
    public function it_get_a_one_signal_model_successfully()
    {
        $obj = new \stdClass();
        $obj->id = random_int(1, 9999);
        $obj->name = 'Testing';
        $obj->basic_auth_key = str_random();

        $mock = $this->mock(OneSignalConsumer::class)->makePartial();
        $mock->shouldReceive('getApp')
            ->never()
            ->andReturn($obj);

        $app = SignalApp::get([
            'id' => random_int(1, 9999),
            'key' => str_random()
        ]);

        $this->assertInstanceOf(\Bondacom\antenna\SignalApp::class, $app);
    }

    /**
     * @test
     */
    public function it_updates_a_one_signal_model_successfully()
    {
        $obj = new \stdClass();
        $obj->id = random_int(1, 9999);
        $obj->name = 'Testing';
        $obj->basic_auth_key = str_random();

        $mock = $this->mock(OneSignalConsumer::class)->makePartial();
        $mock->shouldReceive('updateApp')
            ->once()
            ->andReturn($obj);

        $app = new \Bondacom\antenna\SignalApp(random_int(1, 9999), str_random());
        $app->chrome_web_origin = 'https://example.com';
        $result = $app->save();

        $this->assertInstanceOf(\Bondacom\antenna\SignalApp::class, $result);
    }

}
