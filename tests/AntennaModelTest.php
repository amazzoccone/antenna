<?php

namespace Bondacom\antenna\Tests;

use Bondacom\antenna\AntennaModel;

class AntennaModelTest extends TestCase
{
    /**
     * @test
     */
    public function it_get_a_one_signal_model_successfully()
    {
        $app = AntennaModel::find(random_int(1, 9999), str_random());

        $this->assertInstanceOf(AntennaModel::class, $app);
    }

    /**
     * @test
     */
    public function it_updates_a_one_signal_model_successfully()
    {
        $app = AntennaModel::find(random_int(1, 9999), str_random());
        $app->chrome_web_origin = 'https://example.com';
        $result = $app->save();

        $this->assertInstanceOf(AntennaModel::class, $result);
    }

    /**
     * @test
     */
    public function it_creates_a_one_signal_app_successfully()
    {
        $app = AntennaModel::create([
            'name' => 'Testing One Signal Application',
            'chrome_web_origin' => 'https://example.com',
        ]);

        $this->assertInstanceOf(AntennaModel::class, $app);
    }
}
