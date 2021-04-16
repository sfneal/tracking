<?php

namespace Sfneal\Tracking\Utils;

use Sfneal\Tracking\Models\TrackAction;
use Sfneal\Tracking\Models\TrackActivity;
use Sfneal\Tracking\Models\TrackTraffic;

class ModelAdapter
{
    /**
     * Retrieve a `TrackAction` model set from the 'tracking' config.
     *
     * @return TrackAction|string
     */
    public static function TrackAction(): string
    {
        return config('tracking.models.TrackAction', TrackAction::class);
    }

    /**
     * Retrieve a `TrackActivity` model set from the 'tracking' config.
     *
     * @return TrackActivity|string
     */
    public static function TrackActivity(): string
    {
        return config('tracking.models.TrackActivity', TrackActivity::class);
    }

    /**
     * Retrieve a `TrackTraffic` model set from the 'tracking' config.
     *
     * @return TrackTraffic|string
     */
    public static function TrackTraffic(): string
    {
        return config('tracking.models.TrackTraffic', TrackTraffic::class);
    }
}
