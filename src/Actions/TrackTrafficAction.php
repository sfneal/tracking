<?php

namespace Sfneal\Tracking\Actions;

use Illuminate\Support\Facades\Log;
use Sfneal\Actions\ActionStatic;
use Sfneal\Tracking\Models\TrackTraffic;

class TrackTrafficAction extends ActionStatic
{
    /**
     * Retrieve tracking data and then do something with it.
     *
     * @param array $tracking
     *
     * @return void
     */
    public static function execute(array $tracking)
    {
        $flat = arrayFlattenKeys($tracking);

        // Log traffic data to DB
        TrackTraffic::query()->create($flat);

        // Log JSON encoded activity to local log file
        // todo: add to config
        if (env('TRACK_TRAFFIC_LOGGING', false) == true) {
            Log::channel('traffic')->info(json_encode($flat));
        }
    }
}
