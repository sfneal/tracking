<?php

namespace Sfneal\Tracking\Listeners;

use Sfneal\Listeners\AbstractListener;
use Sfneal\Tracking\Actions\TrackTrafficAction;
use Sfneal\Tracking\Events\TrackTrafficEvent;

class TrackTrafficListener extends AbstractListener
{
    /**
     * @var string Queue to use
     */
    public $queue = 'traffic';

    /**
     * Call the TrackTrafficAction.
     *
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
