<?php

namespace Sfneal\Tracking\Actions;

use Illuminate\Database\Eloquent\Model;
use Sfneal\Actions\Action;
use Sfneal\Tracking\Models\TrackActivity;

class TrackActivityAction extends Action
{
    public $model;
    public $request_token;
    public $user_id;
    public $route;
    public $model_changes;
    public $description;

    /**
     * Track a user's action.
     *
     * @param Model       $model
     * @param string|null $request_token
     * @param int         $user_id
     * @param string|null $route
     * @param array       $model_changes
     * @param string|null $description
     */
    public function __construct(
        Model $model,
        string $request_token = null,
        int $user_id = 0,
        string $route = null,
        array $model_changes = [],
        string $description = null
    ) {
        $this->model = $model;
        $this->request_token = $request_token;
        $this->user_id = $user_id;
        $this->route = $route;
        $this->model_changes = $model_changes;
        $this->description = $description;
    }

    /**
     * Track a user's activity/actions.
     *
     * @return void
     */
    public function execute()
    {
        TrackActivity::query()->create([
            'user_id'       => $this->user_id,
            'route'         => $this->route,
            'description'   => $this->description,
            'model_table'   => $this->model->getTable(),
            'model_key'     => $this->model->getKey(),
            'model_changes' => $this->model_changes,
            'request_token' => $this->request_token,
        ]);
    }
}
