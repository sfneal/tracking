<?php

namespace Sfneal\Tracking\Actions;

use Illuminate\Support\Facades\Log;
use Sfneal\Actions\Action;
use Sfneal\Helpers\Arrays\ArrayHelpers;
use Sfneal\Tracking\Models\TrackTraffic;

class TrackTrafficAction extends Action
{
    /**
     * @var array
     */
    private $tracking;

    /**
     * TrackTrafficAction constructor.
     *
     * @param array $tracking
     */
    public function __construct(array $tracking)
    {
        // Flatten tracking data
        $this->tracking = (new ArrayHelpers($tracking))->arrayFlattenKeys();
    }

    /**
     * Retrieve tracking data and then do something with it.
     *
     * @return void
     */
    public function execute()
    {
        // Log traffic data to DB
        // todo: add config value for enabling this
        TrackTraffic::query()->create($this->tracking);

        // Log JSON encoded activity to local log file
        // todo: add use of config
        if (env('TRACK_TRAFFIC_LOGGING', false) == true) {
            // todo: add config value for log channel
            Log::channel('traffic')->info(json_encode($this->tracking));
        }
    }
}
