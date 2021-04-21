<?php

namespace Sfneal\Tracking\Jobs;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Sfneal\Queueables\Job;
use Sfneal\Tracking\Models\TrackAction;
use Sfneal\Tracking\Utils\ModelAdapter;

class TrackActionJob extends Job
{
    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * @var string Description of the action.
     */
    public $action;

    /**
     * @var Collection|Model Model or models effected by the action
     */
    public $model;

    /**
     * @var array array of changes made to the model
     */
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

        $this->onQueue(config('tracking.queue'));
        $this->onConnection(config('tracking.queue_driver'));
    }

    /**
     * Execute the job.
     *
     * @return TrackAction|Model|null
     */
    public function handle(): ?TrackAction
    {
        if ($this->model->exists) {
            return ModelAdapter::TrackAction()::query()->create([
                'action'        => $this->action,
                'model_changes' => $this->model_changes,
                'trackable_id'     => $this->model->getKey(),
                'trackable_type'   => get_class($this->model),
            ]);
        }

        return null;
    }
}
