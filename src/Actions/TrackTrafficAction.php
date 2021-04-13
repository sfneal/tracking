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
        // Store traffic data in database
        if (config('tracking.traffic.store')) {
            TrackTraffic::query()->create($this->tracking);
        }

        // Log JSON encoded activity to local log file
        if (config('tracking.traffic.log')) {
            Log::channel(config('tracking.traffic.log_channel'))->info(json_encode($this->tracking));
        }
    }
}
