<?php

namespace Sfneal\Tracking\Actions;

use Sfneal\Actions\ActionStatic;
use Sfneal\Tracking\Models\TrackTraffic;

class CleanDevTrackingAction extends ActionStatic
{
    /**
     * Execute the Action.
     *
     * @return void
     */
    public static function execute()
    {
        // Delete TrackTraffic data from 'development' envs that don't have associated activity data
        while (! isset($deleted) || $deleted > 0) {
            $deleted = TrackTraffic::query()
                // todo: add use of builder after tests
                ->where('app_environment', '=', 'development')
                ->limit(100)
                ->delete();
        }
    }
}
