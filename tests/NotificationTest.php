<?php

namespace JdPowered\FcmNotificationChannel\Tests;

use JdPowered\FcmNotificationChannel\FcmNotification;
use PHPUnit\Framework\TestCase;
use ZendService\Google\Gcm\Message;

class NotificationTest extends TestCase
{
    /**
     * @var FcmNotification
     */
    protected $message;

    /**
     * Set up the test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->message = new FcmNotification();
    }

    /** @test */
    public function it_provides_a_create_method()
    {
        $message = FcmNotification::create();

        $this->assertInstanceOf(FcmNotification::class, $message);
    }

    /** @test */
    public function it_has_high_priority()
    {
        $this->assertEquals(FcmNotification::PRIORITY_HIGH, $this->message->priority);
    }

    /** @test */
    public function it_has_no_title()
    {
        $this->assertNull($this->message->title);
    }

    /** @test */
    public function it_can_set_the_title()
    {
        $this->message->title('foo');

        $this->assertEquals('foo', $this->message->title);
    }

    /** @test */
    public function it_has_no_message()
    {
        $this->assertNull($this->message->message);
    }

    /** @test */
    public function it_can_set_the_message()
    {
        $this->message->message('bar');

        $this->assertEquals('bar', $this->message->message);
    }

    /** @test */
    public function it_has_default_sound()
    {
        $this->assertEquals(FcmNotification::DEFAULT_SOUND, $this->message->sound);
    }

    /** @test */
    public function it_can_set_the_sound()
    {
        $this->message->sound('baz');

        $this->assertEquals('baz', $this->message->sound);
    }

    /** @test */
    public function it_can_set_the_action()
    {
        $this->message->action('foo', ['bar' => 'baz']);

        $this->assertEquals(['action' => 'foo', 'params' => ['bar' => 'baz']], $this->message->data['action']);
    }

    /** @test */
    public function it_transforms_to_a_packet()
    {
        $packet = $this->message
            ->title('my-title')
            ->message('my-message')
            ->sound('my-sound')
            ->collapseKey('my-collapse-key')
            ->priority(FcmNotification::PRIORITY_NORMAL)
            ->data('foo', 'bar')
            ->action('my-action', ['bar' => 'baz'])
            ->toPacket(['device-token']);

        $this->assertInstanceOf(Message::class, $packet);
        $this->assertEquals('my-title', $packet->getNotification()['title']);
        $this->assertEquals('my-message', $packet->getNotification()['body']);
        $this->assertEquals('my-sound', $packet->getNotification()['sound']);
        $this->assertEquals('my-collapse-key', $packet->getCollapseKey());
        $this->assertEquals(FcmNotification::PRIORITY_NORMAL, $packet->getPriority());
        $this->assertEquals(['foo' => 'bar', 'action' => ['action' => 'my-action', 'params' => ['bar' => 'baz']]], $packet->getData());
        $this->assertEquals(['device-token'], $packet->getRegistrationIds());
    }
}
