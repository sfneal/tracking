<?php

namespace Sfneal\Tracking\Events;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sfneal\Events\Event;
use Sfneal\Tracking\Actions\ParseTraffic;

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
     * @param string|null               $timestamp
     */
    public function __construct(Request $request, $response, string $timestamp = null)
    {
        $this->tracking = (new ParseTraffic($request, $response, $timestamp ?? microtime()))->execute();
    }
}
