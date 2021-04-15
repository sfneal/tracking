<?php

namespace Sfneal\Tracking\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sfneal\Tracking\Events\TrackTrafficEvent;

class TrackTrafficMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Create response
        $response = $next($request);

        // Check if traffic tracking is enabled
        if (config('tracking.traffic.track')) {
            // Add unique ID to be used to relate traffic & activities
            $request->attributes->add(['track_traffic_token' => uniqid()]);

            // Fire tracking event
            $this->track($request, $response);
        }

        // false value signifies that the tracking token was disabled
        else {
            $request->attributes->add(['track_traffic_token' => false]);
        }

        return $response;
    }

    /**
     * Fire the `TrackTrafficEvent`.
     *
     * @param Request                   $request
     * @param Response|RedirectResponse $response
     */
    private function track(Request $request, $response)
    {
        // Fire Traffic Tracker event
        event(new TrackTrafficEvent($request, $response, microtime(true)));
    }
}
