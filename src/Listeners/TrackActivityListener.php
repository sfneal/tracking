<?php

namespace Sfneal\Tracking\Listeners;

use Sfneal\Listeners\Listener;
use Sfneal\Tracking\Actions\TrackActivityAction;
use Sfneal\Tracking\Events\TrackActivityEvent;

class TrackActivityListener extends Listener
{
    /**
     * TrackActivityListener constructor.
     */
    public function __construct()
    {
        $this->onQueue(config('tracking.queue'));
        $this->onConnection(config('tracking.driver'));
    }

    /**
     * Handle the event.
     *
     * @param TrackActivityEvent $event
     *
     * @return void
     */
    public function handle(TrackActivityEvent $event)
    {
        (new TrackActivityAction(
            $event->model,
            $event->request_token,
            $event->user_id ?? 0,
            $event->route,
            $event->model_changes,
            $event->description
        )
        )->execute();
    }
}
