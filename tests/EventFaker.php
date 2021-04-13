<?php

namespace Sfneal\Tracking\Tests;

use Illuminate\Support\Facades\Event;

trait EventFaker
{
    /**
     * Setup Event faking.
     *
     * @return void
     */
    protected function eventFaker(): void
    {
        // Enable event faking
        Event::fake();

        // Assert that no events were dispatched...
        Event::assertNothingDispatched();
    }
}
