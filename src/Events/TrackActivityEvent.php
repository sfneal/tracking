<?php

namespace Sfneal\Tracking\Events;

use Illuminate\Database\Eloquent\Model;
use Sfneal\Events\AbstractEvent;

class TrackActivityEvent extends AbstractEvent
{
    /**
     * @var Model
     */
    public $model;

    /**
     * @var array Array of model changes
     */
    public $model_changes;

    /**
     * Active user's ID.
     *
     * @var int|null
     */
    public $user_id;

    /**
     * @var string TrackTraffic token that associated traffic with activity
     */
    public $request_token;

    /**
     * @var string|null Requested route
     */
    public $route;

    /**
     * @var string|null Session flash message
     */
    public $description;

    /**
     * Create a new event instance.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        // Get array of changes made to the model
        $this->model = $model;
        $this->model_changes = $this->model->getChanges();

        // Set user_id and request_token for associating with traffic tracking data
        $this->user_id = activeUserID();
        $this->request_token = request()->get('track_traffic_token') ?? null;

        // Get the route name
        $this->route = request() && request()->route() ? (request()->route()->getName() ?? null) : null;
        $this->description = session('success') ?? null;
    }
}
