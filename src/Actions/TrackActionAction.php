<?php

namespace Sfneal\Tracking\Actions;

use Illuminate\Database\Eloquent\Model;
use Sfneal\Actions\Action;
use Sfneal\Tracking\Models\TrackAction;

class TrackActionAction extends Action
{
    public $action;
    public $model;
    public $model_changes;

    /**
     * Track a user's action.
     *
     * @param string $action
     * @param Model  $model
     * @param array  $model_changes
     */
    public function __construct(string $action, Model $model, array $model_changes)
    {
        $this->action = $action;
        $this->model = $model;
        $this->model_changes = $model_changes;
    }

    /**
     * Track a user's activity/actions.
     *
     * @return TrackAction|Model
     */
    public function execute(): TrackAction
    {
        return TrackAction::query()->create([
            'action'        => $this->action,
            'model_table'   => $this->model->getTable(),
            'model_key'     => $this->model->getKey(),
            'model_changes' => $this->model_changes,
        ]);
    }
}
