<?php

namespace JdPowered\FcmNotificationChannel;

use ZendService\Google\Gcm\Message as ZendMessage;

class FcmNotification extends FcmDataMessage
{
    /**
     * The title of the notification.
     *
     * @var string
     */
    public $title;

    /**
     * The message of the notification.
     *
     * @var string
     */
    public $message;

    /**
     * FcmNotification sound.
     *
     * @var string
     */
    public $sound = self::DEFAULT_SOUND;

    /**
     * Priority of the message.
     *
     * This is the default priority for notification messages. FCM attempts to
     * deliver high priority messages immediately, allowing the FCM SDK to wake
     * a sleeping device when possible and open a network connection to your
     * app server.
     *
     * @var string
     */
    public $priority = self::PRIORITY_HIGH;

    /**
     * Set the title of the notification.
     *
     * @param string $title
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the message of the notification.
     *
     * @param string $message
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the sound for notification.
     *
     * @param string $sound
     * @return $this
     */
    public function sound($sound)
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * Add an action to the notification.
     *
     * @param string $action
     * @param mixed  $params
     * @return $this
     */
    public function action($action, $params = null)
    {
        return $this->data('action', [
            'action' => $action,
            'params' => $params,
        ]);
    }

    /**
     * Transform notification to a sendable packet.
     *
     * @param $tokens
     * @return ZendMessage
     */
    public function toPacket($tokens)
    {
        return tap(parent::toPacket($tokens), function (ZendMessage $packet) {
            $packet->setNotification([
                'title' => $this->title,
                'body'  => $this->message,
                'sound' => $this->sound,
            ]);
        });
    }
}
