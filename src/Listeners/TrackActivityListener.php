<?php

namespace Sfneal\Tracking\Listeners;

use Sfneal\Listeners\AbstractListener;
use Sfneal\Tracking\Actions\TrackActivityAction;
use Sfneal\Tracking\Events\TrackActivityEvent;

class TrackActivityListener extends AbstractListener
{
    /**
     * @var string Queue to use
     */
    public $queue = 'tracking';

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
