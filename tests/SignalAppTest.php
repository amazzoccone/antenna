<?php

namespace Bondacom\antenna\Tests;

use Bondacom\antenna\AntennaRequester;
use Bondacom\antenna\Facades\SignalApp;

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

        $mock = $this->mock(AntennaRequester::class);
        $mock->shouldReceive('get')->never();

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

        $mock = $this->mock(AntennaRequester::class)->makePartial();
        $mock->shouldReceive('put')->once()->andReturn($obj);
        $mock->shouldReceive('setUserKey')->once()->andReturnSelf();

        $app = new \Bondacom\antenna\SignalApp(random_int(1, 9999), str_random());
        $app->chrome_web_origin = 'https://example.com';
        $result = $app->save();

        $this->assertInstanceOf(\Bondacom\antenna\SignalApp::class, $result);
    }

}
