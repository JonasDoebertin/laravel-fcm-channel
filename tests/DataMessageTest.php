<?php

namespace JdPowered\FcmNotificationChannel\Tests;

use JdPowered\FcmNotificationChannel\FcmDataMessage;
use PHPUnit\Framework\TestCase;
use ZendService\Google\Gcm\Message;

class DataMessageTest extends TestCase
{
    /**
     * @var FcmDataMessage
     */
    protected $message;

    /**
     * Set up the test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->message = new FcmDataMessage();
    }

    /** @test */
    public function it_provides_a_create_method()
    {
        $message = FcmDataMessage::create();

        $this->assertInstanceOf(FcmDataMessage::class, $message);
    }

    /** @test */
    public function it_has_normal_priority()
    {
        $this->assertEquals(FcmDataMessage::PRIORITY_NORMAL, $this->message->priority);
    }

    /** @test */
    public function it_has_no_data()
    {
        $this->assertEquals([], $this->message->data);
    }

    /** @test */
    public function it_can_set_data()
    {
        $this->message->data('foo', 'bar');

        $this->assertEquals('bar', $this->message->data['foo']);
    }

    /** @test */
    public function it_can_set_the_priority()
    {
        $this->message->priority(FcmDataMessage::PRIORITY_HIGH);

        $this->assertEquals(FcmDataMessage::PRIORITY_HIGH, $this->message->priority);
    }

    /** @test */
    public function it_has_no_collapse_key()
    {
        $this->assertNull($this->message->collapseKey);
    }

    /** @test */
    public function it_can_set_the_collapse_key()
    {
        $this->message->collapseKey('my-collapse-key');

        $this->assertEquals('my-collapse-key', $this->message->collapseKey);
    }

    /** @test */
    public function it_transforms_to_a_packet()
    {
        $packet = $this->message
            ->collapseKey('my-collapse-key')
            ->priority(FcmDataMessage::PRIORITY_HIGH)
            ->data('foo', 'bar')
            ->toPacket(['device-token']);

        $this->assertInstanceOf(Message::class, $packet);
        $this->assertEquals('my-collapse-key', $packet->getCollapseKey());
        $this->assertEquals(FcmDataMessage::PRIORITY_HIGH, $packet->getPriority());
        $this->assertEquals(['foo' => 'bar'], $packet->getData());
        $this->assertEquals(['device-token'], $packet->getRegistrationIds());
    }
}
