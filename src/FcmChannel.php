<?php

namespace JdPowered\FcmNotificationChannel;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Notification;
use JdPowered\FcmNotificationChannel\Exceptions\FcmNotificationFailed;
use JdPowered\FcmNotificationChannel\Exceptions\FcmRuntimeException;
use ZendService\Google\Exception\RuntimeException;
use ZendService\Google\Gcm\Client;
use ZendService\Google\Gcm\Response;

class FcmChannel
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
     * Channel constructor.
     *
     * @param Client     $client
     * @param Dispatcher $events
     */
    public function __construct(Client $client, Dispatcher $events)
    {
        $this->client = $client;
        $this->events = $events;
    }

    /**
     * Send the notification to Google Cloud Messaging.
     *
     * @param              $notifiable
     * @param Notification $notification
     * @return bool
     * @throws FcmRuntimeException
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$tokens = (array) $notifiable->routeNotificationFor('fcm')) {
            return false;
        }

        $message = $notification->toFcm($notifiable);

        try {
            $response = $this->client->send($message->toPacket($tokens));
        } catch (RuntimeException $e) {
            throw FcmRuntimeException::createFromException($e);
        }

        if ($response->getFailureCount() !== 0) {
            $this->handleFailedNotification($notifiable, $notification, $response);
        }

        return true;
    }

    /**
     * Handle a failed notification.
     *
     * @param              $notifiable
     * @param FcmNotification $notification
     * @param Response $response
     */
    protected function handleFailedNotification($notifiable, Notification $notification, Response $response)
    {
        $results = $response->getResults();

        foreach ($results as $token => $result) {
            if (!isset($result['error'])) {
                continue;
            }

            $this->events->fire(
                new FcmNotificationFailed($notifiable, $notification, get_class($this), [
                    'token' => $token,
                    'error' => $result['error'],
                ])
            );
        }
    }
}
