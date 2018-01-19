<?php

namespace JdPowered\FcmNotificationChannel\Tests;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use JdPowered\FcmNotificationChannel\FcmDataMessage;
use JdPowered\FcmNotificationChannel\FcmChannel;
use JdPowered\FcmNotificationChannel\FcmNotification;
use Mockery;
use PHPUnit\Framework\TestCase;
use ZendService\Google\Gcm\Client;

class ChannelTest extends TestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * @var FcmChannel
     */
    protected $channel;

    /**
     * @var TestNotifiable
     */
    protected $notifiable;

    /**
     * Set up the test.
     */
    public function setUp()
    {
        $this->client = Mockery::mock(Client::class);
        $this->events = Mockery::mock(Dispatcher::class);
        $this->channel = new FcmChannel($this->client, $this->events);
        $this->notifiable = new TestNotifiable();
    }

    /**
     * Tear down the test.
     */
    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_can_send_a_data_message()
    {
        $this->client->shouldReceive('send')->once();

        $this->channel->send($this->notifiable, new TestDataMessage());
    }

    /** @test */
    public function it_can_send_a_notification()
    {
        $this->client->shouldReceive('send')->once();

        $result = $this->channel->send($this->notifiable, new TestNotification());

        $this->assertTrue($result);
    }

    /** @test */
    public function it_does_not_try_to_send_a_notification_When_no_device_id_is_provided()
    {
        $this->client->shouldNotReceive('send');

        $result = $this->channel->send(new TestNotifiableWithoutDevice(), new TestNotification());

        $this->assertFalse($result);
    }
}

class TestNotifiable
{
    use Notifiable;

    /**
     * @return array
     */
    public function routeNotificationForFcm()
    {
        return ['device-id'];
    }
}

class TestNotifiableWithoutDevice
{
    use Notifiable;

    /**
     * @return array
     */
    public function routeNotificationForFcm()
    {
        return [];
    }
}

class TestDataMessage extends Notification
{
    public function toFcm($notifiable)
    {
        return FcmDataMessage::create();
    }
}

class TestNotification extends Notification
{
    public function toFcm($notifiable)
    {
        return FcmNotification::create();
    }
}
