<?php

namespace Sfneal\Tracking\Actions;

use Illuminate\Database\Eloquent\Model;
use Sfneal\Actions\Action;
use Sfneal\Tracking\Models\TrackActivity;

class TrackActivityAction extends Action
{
    /**
     * @var Model
     */
    public $model;

    /**
     * @var string|null
     */
    public $request_token;

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var string|null
     */
    public $route;

    /**
     * @var array
     */
    public $model_changes;

    /**
     * @var string|null
     */
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
     * @return TrackActivity|Model
     */
    public function execute(): TrackActivity
    {
        return TrackActivity::query()->create([
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
