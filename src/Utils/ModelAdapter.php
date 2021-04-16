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
     * @return TrackAction
     */
    public static function TrackAction(): TrackAction
    {
        return config('tracking.models.TrackAction', TrackAction::class);
    }

    /**
     * Retrieve a `TrackActivity` model set from the 'tracking' config.
     *
     * @return TrackActivity
     */
    public static function TrackActivity(): TrackActivity
    {
        return config('tracking.models.TrackActivity', TrackActivity::class);
    }

    /**
     * Retrieve a `TrackTraffic` model set from the 'tracking' config.
     *
     * @return TrackTraffic
     */
    public static function TrackTraffic(): TrackTraffic
    {
        return config('tracking.models.TrackTraffic', TrackTraffic::class);
    }
}
