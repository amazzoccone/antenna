<?php

namespace Bondacom\Antenna\Tests;

use Bondacom\Antenna\AntennaModel;
use Bondacom\Antenna\Facades\Antenna;

class AntennaTest extends TestCase
{
    /**
     * @test
     */
    public function app_method_returns_the_default_config_app()
    {
        $app = Antenna::app();

        $this->assertInstanceOf(AntennaModel::class, $app);
    }

    /**
     * @test
     */
    public function app_method_returns_a_config_app()
    {
        $app = Antenna::app('default');

        $this->assertInstanceOf(AntennaModel::class, $app);
    }

    /**
     * @test
     */
    public function app_method_returns_a_custom_config_app()
    {
        $app = Antenna::app([
            'id' => random_int(1, 99999),
            'key' => str_random()
        ]);

        $this->assertInstanceOf(AntennaModel::class, $app);
    }
}
