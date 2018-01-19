<?php

namespace JdPowered\FcmNotificationChannel;

use Illuminate\Support\ServiceProvider;
use Zend\Http\Client\Adapter\Curl;
use ZendService\Google\Gcm\Client;

class FcmServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function register()
    {
        $this->app->when(FcmChannel::class)
            ->needs(Client::class)
            ->give(function () {
                return tap(new Client(), function (Client $client) {
                    $client->setApiKey(config('broadcasting.connections.fcm.key'));
                    $client->getHttpClient()->setAdapter(new Curl());
                });
            });
    }
}
