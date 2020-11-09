<?php

namespace Sfneal\Tracking\Actions;

use Sfneal\Actions\AbstractActionStatic;
use Sfneal\Tracking\Models\TrackTraffic;

class CleanDevTrackingAction extends AbstractActionStatic
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
                ->where('app_environment', '=', 'development')
                ->limit(100)->delete();
        }
    }
}
