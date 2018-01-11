<?php

namespace Bondacom\Antenna\Tests\Unit;

use Bondacom\Antenna\Drivers\OneSignal\Requester;
use Bondacom\Antenna\Exceptions\AntennaBadRequestException;
use Bondacom\Antenna\Exceptions\AntennaNotFoundException;
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
        $data = $this->fakeAppData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andReturnSelf();
        $mock->shouldReceive('responseContent')->once()->andReturn($data);

        $app = App::find(str_random(), str_random());

        $this->assertInstanceOf(App::class, $app);
    }

    /**
     * @test
     */
    public function it_returns_null_if_app_is_empty()
    {
        $this->assertNull(App::find(''));
    }

    /**
     * @test
     */
    public function it_returns_null_if_app_not_exists()
    {
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andThrow(AntennaNotFoundException::class);

        $this->assertNull(App::find(str_random()));
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_app_is_empty()
    {
        $this->expectException(AntennaNotFoundException::class);
        App::findOrFail('');
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_app_not_exists()
    {
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andThrow(AntennaNotFoundException::class);

        $this->expectException(AntennaNotFoundException::class);
        App::findOrFail(str_random());
    }

    /**
     * @test
     */
    public function it_updates_a_one_signal_model_successfully()
    {
        $data = $this->fakeAppData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andReturnSelf();
        $mock->shouldReceive('put')->once()->andReturnSelf();
        $mock->shouldReceive('responseContent')->twice()->andReturn($data);

        $app = App::find(str_random(), str_random());
        $app->chrome_web_origin = 'https://example.com';
        $result = $app->save();

        $this->assertInstanceOf(App::class, $result);
    }

    /**
     * @test
     */
    public function it_creates_a_one_signal_app_successfully()
    {
        $data = $this->fakeAppData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('post')->once()->andReturnSelf();
        $mock->shouldReceive('responseContent')->once()->andReturn($data);

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
        $data = $this->fakeAppData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andReturnSelf();
        $mock->shouldReceive('responseContent')->once()->andReturn($data);
        $mock->shouldReceive('put')->once()->andThrow(AntennaBadRequestException::class);

        $app = App::find(str_random(), str_random());
        $app->gcm_key = 'dnudsijsd23';

        $this->expectException(AntennaBadRequestException::class);
        $app->save();
    }

    /**
     * @test
     */
    public function getAttributes_method_returns_all_attributes()
    {
        $data = $this->fakeAppData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andReturnSelf();
        $mock->shouldReceive('responseContent')->once()->andReturn($data);

        $app = App::find($data['id'], $data['basic_auth_key']);
        $attributes = $app->getAttributes();

        $this->assertEquals($data, $attributes);
    }

    /**
     * @test
     */
    public function it_returns_attribute()
    {
        $data = $this->fakeAppData();
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andReturnSelf();
        $mock->shouldReceive('responseContent')->once()->andReturn($data);

        $app = App::find($data['id']);
        $this->assertEquals($data['id'], $app->id);
        $this->assertEquals($data['name'], $app->name);
    }
}
