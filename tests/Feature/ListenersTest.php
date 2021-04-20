<?php

namespace Sfneal\Tracking\Tests\Feature;

use Illuminate\Support\Facades\Event;
use Sfneal\Testing\Utils\Traits\EventFaker;
use Sfneal\Tracking\Events\TrackActivityEvent;
use Sfneal\Tracking\Events\TrackTrafficEvent;
use Sfneal\Tracking\Listeners\TrackActivityListener;
use Sfneal\Tracking\Listeners\TrackTrafficListener;
use Sfneal\Tracking\Tests\TestCase;

class ListenersTest extends TestCase
{
    use EventFaker;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->eventFaker();
    }

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
