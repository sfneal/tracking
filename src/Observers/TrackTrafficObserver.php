<?php

namespace Sfneal\Tracking\Observers;

use Sfneal\Observers\Observer;
use Sfneal\Observers\Saving;
use Sfneal\Tracking\Models\TrackTraffic;

class TrackTrafficObserver extends Observer implements Saving
{
    /**
     * Handle the TrackTraffic "saved" event.
     *
     * Set app_environment attribute value.
     *
     * @param TrackTraffic $tracking
     *
     * @return void
     */
    public function saving(TrackTraffic $tracking)
    {
        $tracking->setAppEnvironmentAttribute($tracking->app_environment);
    }
}
