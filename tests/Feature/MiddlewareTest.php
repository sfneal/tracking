<?php

namespace Sfneal\Tracking\Tests\Feature;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Sfneal\Tracking\Events\TrackTrafficEvent;
use Sfneal\Tracking\Middleware\TrackTrafficMiddleware;
use Sfneal\Tracking\Tests\CreateRequest;
use Sfneal\Tracking\Tests\EventFaker;
use Sfneal\Tracking\Tests\TestCase;

class MiddlewareTest extends TestCase
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

        $this->eventFaker();
    }

    /** @test */
    public function middleware_not_enabled()
    {
        // Mock request
        $this->get('/');

        // Assert that no events have been pushed
        Event::assertNotDispatched(TrackTrafficEvent::class);
    }

    /** @test */
    public function middleware_enabled()
    {
        // Enable middleware
        $this->enableMiddleware();

        // Mock request
        $this->get('/');

        // Assert that the event has been pushed
        Event::assertDispatched(TrackTrafficEvent::class);
    }

    /** @test */
    public function middleware_adds_tracking_token()
    {
        // Enable middleware
        $this->enableMiddleware();

        // Mock request
        $this->get('/');

        // Assert the Event was pushed
        Event::assertDispatched(TrackTrafficEvent::class, function (TrackTrafficEvent $event) {
            return is_string($event->tracking['request']['token']);
        });
    }

    /** @test */
    public function middleware_doesnt_add_tracking_token()
    {
        // Disable tracking
        $this->app['config']->set('tracking.traffic.track', false);

        // Enable middleware
        $this->enableMiddleware();

        // Mock request
        $this->get('/');

        // Assert the Event was pushed
        Event::assertNotDispatched(TrackTrafficEvent::class, function (TrackTrafficEvent $event) {
            return is_null($event->tracking['request']['token']);
        });
    }

    private function enableMiddleware(): void
    {
        // Enable middleware
        Route::middleware(TrackTrafficMiddleware::class)->any('/', function () {
            return 'OK';
        });
    }
}
