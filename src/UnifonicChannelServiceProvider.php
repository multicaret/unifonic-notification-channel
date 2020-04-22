<?php

namespace Multicaret\Notifications;

use Illuminate\Support\ServiceProvider;
use Multicaret\Unifonic\UnifonicManager;

class UnifonicChannelServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        \Notification::extend('unifonic', function () {
            return new Channels\UnifonicSmsChannel(new UnifonicManager);
        });
    }
}
