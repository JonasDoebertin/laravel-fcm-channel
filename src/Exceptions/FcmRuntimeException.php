<?php

namespace JdPowered\FcmNotificationChannel\Exceptions;

class FcmRuntimeException extends \RuntimeException
{
    /**
     * Create a new instance from a FCM client exception.
     *
     * @param \Exception $exception
     * @return FcmRuntimeException
     */
    public static function createFromException(\Exception $exception)
    {
        return new static("Cannot deliver message to FCM: {$exception->getMessage()}", 0, $exception);
    }
}