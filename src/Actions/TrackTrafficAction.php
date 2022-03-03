<?php

namespace Sfneal\Tracking\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Sfneal\Actions\Action;
use Sfneal\Helpers\Arrays\ArrayHelpers;
use Sfneal\Tracking\Models\TrackTraffic;
use Sfneal\Tracking\Utils\ModelAdapter;

class TrackTrafficAction extends Action
{
    /**
     * @var array
     */
    private $tracking;

    /**
     * TrackTrafficAction constructor.
     *
     * @param  array  $tracking
     */
    public function __construct(array $tracking)
    {
        // Flatten tracking data
        $this->tracking = ArrayHelpers::from($tracking)->flattenKeys()->get();
    }

    /**
     * Retrieve tracking data and then do something with it.
     *
     * @return TrackTraffic|Model
     */
    public function execute(): ?TrackTraffic
    {
        // Log JSON encoded activity to local log file
        if (config('tracking.traffic.log')) {
            Log::channel(config('tracking.traffic.log_channel'))->info(json_encode($this->tracking));
        }

        // Store traffic data in database
        if (config('tracking.traffic.store')) {
            return ModelAdapter::TrackTraffic()::query()->create($this->tracking);
        }

        return null;
    }
}
