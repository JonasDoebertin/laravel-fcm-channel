<?php

namespace JdPowered\FcmNotificationChannel;

use ZendService\Google\Gcm\Message as ZendMessage;

class FcmDataMessage
{
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_HIGH = 'high';

    const DEFAULT_SOUND = 'default';

    /**
     * Data of the message.
     *
     * @var array
     */
    public $data = [];

    /**
     * Collapse key of the message.
     *
     * @var string
     */
    public $collapseKey;

    /**
     * Priority of the message.
     *
     * This is the default priority for data messages. Normal priority messages
     * won't open network connections on a sleeping device, and their delivery
     * may be delayed to conserve battery. For less time-sensitive messages,
     * such as notifications of new email or other data to sync, choose normal
     * delivery priority.
     *
     * @var string
     */
    public $priority = self::PRIORITY_NORMAL;

    /**
     * Create a new instance.
     *
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Add a data key to the message.
     *
     * @param string $key
     * @param mixed  $value
     * @return $this
     */
    public function data($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Override the data of the message.
     *
     * @param array $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set the collapse key for the message.
     *
     * @param string $collapseKey
     * @return $this
     */
    public function collapseKey($collapseKey)
    {
        $this->collapseKey = $collapseKey;

        return $this;
    }

    /**
     * Set the priority for the message.
     *
     * @param $priority
     * @return $this
     */
    public function priority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Transform message to a sendable packet.
     *
     * @param $tokens
     * @return ZendMessage
     */
    public function toPacket($tokens)
    {
        return tap(new ZendMessage(), function (ZendMessage $packet) use ($tokens) {
            $packet->setRegistrationIds($tokens);
            $packet->setCollapseKey($this->collapseKey);
            $packet->setPriority($this->priority);
            $packet->setData($this->data);
        });
    }
}
