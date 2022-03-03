<?php

namespace Sfneal\Tracking\Observers;

use Illuminate\Database\Eloquent\Model;
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
     * @param  TrackTraffic|Model  $tracking
     * @return void
     */
    public function saving(Model $tracking)
    {
        $tracking->setAppEnvironmentAttribute($tracking->app_environment);
    }
}
