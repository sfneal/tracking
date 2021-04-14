<?php

namespace Sfneal\Tracking\Tests\Feature;

use Illuminate\Support\Facades\Event;
use Sfneal\Testing\Models\People;
use Sfneal\Tracking\Events\TrackActivityEvent;
use Sfneal\Tracking\Events\TrackTrafficEvent;
use Sfneal\Tracking\Tests\CreateRequest;
use Sfneal\Tracking\Tests\EventFaker;
use Sfneal\Tracking\Tests\TestCase;

class EventsTest extends TestCase
{
    use EventFaker;
    use CreateRequest;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Enable event faking
        $this->eventFaker();
    }

    /** @test */
    public function track_activity_event_can_be_fired()
    {
        // Assert that no events have been pushed
        Event::assertNotDispatched(TrackActivityEvent::class);

        // Create a Model
        $model = People::factory()->create();

        // Dispatch the event
        event(new TrackActivityEvent($model));

        // Assert the Event was pushed
        Event::assertDispatched(TrackActivityEvent::class);
    }

    /** @test */
    public function track_traffic_event_can_be_fired()
    {
        // Assert that no events have been pushed
        Event::assertNotDispatched(TrackTrafficEvent::class);

        // Dispatch the event
        event(new TrackTrafficEvent($this->createRequest(), response('OK'), microtime(true)));

        // Assert the Event was pushed
        Event::assertDispatched(TrackTrafficEvent::class);
    }
}
