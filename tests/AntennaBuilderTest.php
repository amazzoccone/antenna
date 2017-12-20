<?php

namespace Bondacom\antenna\Tests;

use Bondacom\antenna\AntennaRequester;
use Bondacom\antenna\Facades\AntennaBuilder;

class AntennaBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_a_one_signal_app_successfully()
    {
        $obj = new \stdClass();
        $obj->id = random_int(1, 9999);
        $obj->name = 'Testing';
        $obj->basic_auth_key = str_random();

        $mock = $this->mock(AntennaRequester::class)->makePartial();
        $mock->shouldReceive('post')->once()->andReturn($obj);
        $mock->shouldReceive('setUserKey')->once()->andReturnSelf();

        $app = AntennaBuilder::create([
            'name' => 'Testing One Signal Application',
            'chrome_web_origin' => 'https://example.com',
        ]);

        $this->assertInstanceOf(\Bondacom\antenna\SignalApp::class, $app);
    }
}
