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
        $obj = new stdClass();
        $obj->id = random_int(1, 9999);
        $obj->basic_auth_key = str_random();

        $this->mock(OneSignalConsumer::class)
            ->shouldReceive('createApp')
            ->once()
            ->andReturn($obj);

        $app = AntennaBuilder::create([
            'name' => 'Testing One Signal Application',
            'gcm_key' => env('ANDROID_PUSH_API_KEY'),
            'apns_env' => env('IOS_PUSH_ENVIRONMENT', ''),
            'apns_p12_password' => env('IOS_P12_PASSWORD', ''),
            'chrome_web_origin' => 'https://example.com',
        ]);

        $this->assertInstanceOf(SignalApp::class, $app);
        
    }
}
