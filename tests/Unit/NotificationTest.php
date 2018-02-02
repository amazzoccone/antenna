<?php

namespace Bondacom\Antenna\Tests\Unit;

use Bondacom\Antenna\Drivers\OneSignal\Requester;
use Bondacom\Antenna\Models\App;
use Bondacom\Antenna\Models\Notification;
use Bondacom\Antenna\Tests\TestCase;
use Bondacom\Antenna\Utilities\Builder;

class NotificationTest extends TestCase
{
    /**
     * @test
     */
    public function app_has_notifications_relation()
    {
        $app = (new App())->setAttributes($this->fakeAppData());

        $this->assertInstanceOf(Builder::class, $app->notification());
    }

    /**
     * @test
     */
    public function it_find_a_notification_from_an_app()
    {
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('get')->once()->andReturnSelf();
        $mock->shouldReceive('responseContent')->once()->andReturn($this->fakeNotificationData());

        $app = (new App())->setAttributes($this->fakeAppData());
        $notification = $app->notification()->find(str_random());

        $this->assertInstanceOf(Notification::class, $notification);
    }

    /**
     * @test
     */
    public function it_deletes_a_notification_from_an_app()
    {
        $mock = $this->mock(Requester::class)->makePartial();
        $mock->shouldReceive('delete')->once()->andReturnSelf();

        $notification = (new Notification())->setAttributes($this->fakeNotificationData());
        $notification->appendParameters([
            'app_id' => str_random(),
            'app_key' => str_random(),
        ]);

        $notification->delete();
    }
}
