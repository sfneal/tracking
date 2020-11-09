<?php

namespace Sfneal\Tracking\Jobs;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Sfneal\Queueables\AbstractJob;
use Sfneal\Tracking\Actions\TrackActionAction;

// TODO: create package Tracking
class TrackActionJob extends AbstractJob
{
    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * @var string Queue to use
     */
    public $queue = 'tracking';

    public $action;
    public $model;
    public $model_changes;

    /**
     * Track a user's action.
     *
     * @param string           $action
     * @param Model|Collection $model
     */
    public function __construct(string $action, $model)
    {
        $this->action = $action;
        $this->model = $model;

        try {
            $this->model_changes = $model->getChanges();
        } catch (Exception $exception) {
            $this->model_changes = [];
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->model->exists) {
            (new TrackActionAction(
                $this->action,
                $this->model,
                $this->model_changes
            )
            )->execute();
        }
    }
}
