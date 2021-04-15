<?php

namespace Sfneal\Tracking\Jobs;

use Sfneal\Queueables\Job;
use Sfneal\Tracking\Models\TrackTraffic;

class CleanDevTrackingJob extends Job
{
    /**
     * @var string Queue to use
     */
    public $queue = 'low';

    /**
     * @var string Queue connection to use
     */
    public $connection = 'database';

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Delete TrackTraffic data from 'development' envs that don't have associated activity data
        while (! isset($deleted) || $deleted > 0) {
            $deleted = TrackTraffic::query()
                ->whereEnvironmentDevelopment()
                ->limit(100)
                ->delete();
        }
    }
}
