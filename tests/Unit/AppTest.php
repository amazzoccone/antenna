<?php

namespace Bondacom\Antenna\Tests\Unit;

use Bondacom\Antenna\Drivers\OneSignal\Requester;
use Bondacom\Antenna\Exceptions\AntennaServerException;
use Bondacom\Antenna\Exceptions\MissingOneSignalAppInformation;
use Bondacom\Antenna\Exceptions\MissingOneSignalData;
use Bondacom\Antenna\Models\App;
use Bondacom\Antenna\Tests\TestCase;

class AppTest extends TestCase
{
    /**
     * @test
     */
    public function it_get_a_one_signal_model_successfully()
    {
        $data = $this->fakeRequesterData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andReturn($data);

        $app = App::find(random_int(1, 9999), str_random());

        $this->assertInstanceOf(App::class, $app);
    }

    /**
     * @test
     */
    public function it_updates_a_one_signal_model_successfully()
    {
        $data = $this->fakeRequesterData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andReturn($data);
        $mock->shouldReceive('put')->once()->andReturn($data);

        $app = App::find(random_int(1, 9999), str_random());
        $app->chrome_web_origin = 'https://example.com';
        $result = $app->save();

        $this->assertInstanceOf(App::class, $result);
    }

    /**
     * @test
     */
    public function it_creates_a_one_signal_app_successfully()
    {
        $data = $this->fakeRequesterData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('post')->once()->andReturn($data);

        $app = App::create([
            'name' => 'Testing One Signal Application',
            'chrome_web_origin' => 'https://example.com',
        ]);

        $this->assertInstanceOf(App::class, $app);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_tries_to_create_an_app_but_not_have_required_fields()
    {
        $this->expectException(MissingOneSignalData::class);
        App::create([
            'chrome_web_origin' => 'https://example.com',
        ]);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_fails_when_save()
    {
        $data = $this->fakeRequesterData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andReturn($data);
        $mock->shouldReceive('put')->once()->andReturn([
            'errors' => [
                "Your API Key is incorrect. It should look something like: .."
            ]
        ]);

        $app = App::find(random_int(1, 9999), str_random());
        $app->gcm_key = 'dnudsijsd23';

        $this->expectException(AntennaServerException::class);
        $app->save();
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_driver_has_not_required_app_information()
    {
        $this->expectException(MissingOneSignalAppInformation::class);
        App::find('', '');
    }

    /**
     * @test
     */
    public function getAttributes_method_returns_all_attributes()
    {
        $data = $this->fakeRequesterData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andReturn($data);

        $app = App::find(random_int(1, 9999), str_random());
        $attributes = $app->getAttributes();

        $this->assertEquals($data, $attributes);
    }

    /**
     * @test
     */
    public function it_returns_attribute()
    {
        $data = $this->fakeRequesterData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andReturn($data);

        $app = App::find(random_int(1, 9999), str_random());
        $this->assertEquals($data['id'], $app->id);
        $this->assertEquals($data['name'], $app->name);
    }
}
