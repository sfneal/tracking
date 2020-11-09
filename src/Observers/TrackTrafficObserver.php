<?php

namespace Sfneal\Tracking\Observers;

use Sfneal\Observers\AbstractObserver;
use Sfneal\Observers\Saving;
use Sfneal\Tracking\Models\TrackTraffic;

class TrackTrafficObserver extends AbstractObserver implements Saving
{
    /**
     * Handle the TrackTraffic "saved" event.
     *
     * Set app_environment attribute value.
     *
     * @param TrackTraffic $tacking
     *
     * @return void
     */
    public function saving(TrackTraffic $tacking)
    {
        $tacking->setAppEnvironmentAttribute();
    }
}
