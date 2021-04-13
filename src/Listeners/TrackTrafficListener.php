<?php

namespace Sfneal\Tracking\Listeners;

use Sfneal\Listeners\Listener;
use Sfneal\Tracking\Actions\TrackTrafficAction;
use Sfneal\Tracking\Events\TrackTrafficEvent;

class TrackTrafficListener extends Listener
{
    /**
     * @var string Queue to use
     */
    public $queue = 'traffic';

    /**
     * Retrieve tracking data and then do something with it.
     *
     * @param TrackTrafficEvent $event
     *
     * @return void
     */
    public function handle(TrackTrafficEvent $event)
    {
        (new TrackTrafficAction($event->tracking))->execute();
    }
}
