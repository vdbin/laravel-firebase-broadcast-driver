<?php

namespace vdbin\Firebase;

use vdbin\Firebase\Broadcasters\FSDB;
use vdbin\Firebase\Broadcasters\RTDB;
use vdbin\Firebase\Broadcasters\FCM;
use Illuminate\Support\ServiceProvider;
use Illuminate\Broadcasting\BroadcastManager;

class FireBaseBroadcastProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        app(BroadcastManager::class)->extend('firebase', function ($app) {
            $config = config('broadcasting.connections.firebase');

            return match ($config['type']) {
                'database' => new RTDB($config),
                'messaging' => new FCM($config),
                'firestore' => new FSDB($config),
                default => new FSDB($config),
            };
        });
    }

    public function register()
    {
    }
}
