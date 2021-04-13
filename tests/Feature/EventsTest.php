<?php


namespace Sfneal\Tracking\Tests\Feature;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Sfneal\Tracking\Events\TrackTrafficEvent;
use Sfneal\Tracking\Middleware\TrackTrafficMiddleware;
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

        // Enable middleware
        Route::middleware(TrackTrafficMiddleware::class)->any('/', function () {
            return 'OK';
        });
    }

    /** @test */
    public function track_activity_event_can_be_fired()
    {
        // todo: finish building tests
        $this->assertTrue(true);
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
