<?php

namespace Sfneal\Tracking\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Sfneal\Tracking\Events\TrackActivityEvent;
use Sfneal\Tracking\Events\TrackTrafficEvent;
use Sfneal\Tracking\Listeners\TrackActivityListener;
use Sfneal\Tracking\Listeners\TrackTrafficListener;
use Sfneal\Tracking\Models\TrackTraffic;
use Sfneal\Tracking\Observers\TrackTrafficObserver;

class TrackingEventServiceProvider extends EventServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Activity Tracking
        TrackActivityEvent::class => [
            TrackActivityListener::class,
        ],

        // Traffic Tracking
        TrackTrafficEvent::class => [
            TrackTrafficListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Observers
        TrackTraffic::observe(TrackTrafficObserver::class);
    }
}
