<?php

namespace Sfneal\Tracking\Tests\Feature;

use Illuminate\Support\Facades\Event;
use Sfneal\Tracking\Events\TrackActivityEvent;
use Sfneal\Tracking\Events\TrackTrafficEvent;
use Sfneal\Tracking\Listeners\TrackActivityListener;
use Sfneal\Tracking\Listeners\TrackTrafficListener;
use Sfneal\Tracking\Tests\EventFakerSetup;
use Sfneal\Tracking\Tests\TestCase;

class ListenersTest extends TestCase
{
    use EventFakerSetup;

    /** @test */
    public function listeners_are_attached_to_events()
    {
        Event::assertListening(
            TrackActivityEvent::class,
            TrackActivityListener::class,
        );
        Event::assertListening(
            TrackTrafficEvent::class,
            TrackTrafficListener::class,
        );
    }
}
