<?php

namespace Sfneal\Tracking\Jobs;

use Sfneal\Queueables\Job;
use Sfneal\Tracking\Actions\CleanDevTrackingAction;

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
        CleanDevTrackingAction::execute();
    }
}
