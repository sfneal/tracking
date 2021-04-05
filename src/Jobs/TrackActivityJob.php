<?php

namespace Sfneal\Tracking\Jobs;

use Illuminate\Database\Eloquent\Model;
use Sfneal\Queueables\Job;
use Sfneal\Tracking\Actions\TrackActivityAction;

class TrackActivityJob extends Job
{
    /**
     * @var string Queue to use
     */
    public $queue = 'tracking';

    public $model;
    public $request_token;
    public $user_id;
    public $route;
    public $model_changes;
    public $description;

    /**
     * Track a user's route.
     *
     * @param Model $model
     * @param string $request_token
     * @param int $user_id
     * @param string $route
     * @param array $model_changes
     * @param string|null $description
     */
    public function __construct(Model $model,
                                string $request_token,
                                int $user_id,
                                string $route,
                                array $model_changes = [],
                                string $description = null)
    {
        $this->model = $model;
        $this->request_token = $request_token;
        $this->user_id = $user_id;
        $this->route = $route;
        $this->model_changes = $model_changes;
        $this->description = $description;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new TrackActivityAction(
            $this->model,
            $this->request_token,
            $this->user_id,
            $this->route,
            $this->model_changes,
            $this->description)
        )->execute();
    }
}
