<?php

namespace Sfneal\Tracking\Jobs;

use Sfneal\Queueables\Job;
use Sfneal\Tracking\Utils\ModelAdapter;

class CleanDevTrackingJob extends Job
{
    /**
     * CleanDevTrackingJob constructor.
     */
    public function __construct()
    {
        $this->onQueue(config('tracking.queue'));
        $this->onConnection(config('tracking.queue_driver'));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Delete TrackTraffic data from 'development' envs that don't have associated activity data
        while (! isset($deleted) || $deleted > 0) {
            $deleted = ModelAdapter::TrackTraffic()::query()
                ->whereEnvironmentDevelopment()
                ->limit(100)
                ->delete();
        }
    }
}
