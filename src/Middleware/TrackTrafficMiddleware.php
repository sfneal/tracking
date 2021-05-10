<?php

namespace Sfneal\Tracking\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sfneal\Controllers\Middleware;
use Sfneal\Tracking\Events\TrackTrafficEvent;

class TrackTrafficMiddleware implements Middleware
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
        // Add unique ID to be used to relate traffic & activities
        $request->attributes->add(['track_traffic_token' => uniqid()]);

        // Create response
        $response = $next($request);

        // Check if traffic tracking is enabled
        if (config('tracking.traffic.track')) {

            // Fire Traffic Tracker event
            event(new TrackTrafficEvent($request, $response, microtime(true)));
        }

        // Return the response
        return $response;
    }
}
