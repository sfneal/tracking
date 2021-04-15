<?php

namespace Sfneal\Tracking\Jobs;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Sfneal\Queueables\Job;
use Sfneal\Tracking\Models\TrackAction;

class TrackActionJob extends Job
{
    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    // todo: add to config
    /**
     * @var string Queue to use
     */
    public $queue = 'tracking';

    // todo: improve type hinting
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
     * @return TrackAction|Model|null
     */
    public function handle(): ?TrackAction
    {
        if ($this->model->exists) {
            return TrackAction::query()->create([
                'action'        => $this->action,
                'model_table'   => $this->model->getTable(),
                'model_key'     => $this->model->getKey(),
                'model_changes' => $this->model_changes,
            ]);
        }

        return null;
    }
}
