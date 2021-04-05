<?php

namespace Sfneal\Tracking\Events;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sfneal\Events\Event;
use Sfneal\Tracking\Actions\ParseTrafficAction;

class TrackTrafficEvent extends Event
{
    /**
     * @var array
     */
    public $tracking = [];

    /**
     * Create a new event instance.
     *
     * @param Request                   $request
     * @param Response|RedirectResponse $response
     * @param string                    $time_stamp
     */
    public function __construct(Request $request, $response, string $time_stamp)
    {
        $this->tracking = (new ParseTrafficAction($request, $response, $time_stamp))->execute();
    }
}
