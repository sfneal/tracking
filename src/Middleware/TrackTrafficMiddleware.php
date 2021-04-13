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
        // todo: add to if statement body?
        // Add unique ID to be used to relate traffic & activities
        $request->attributes->add(['track_traffic_token' => uniqid()]);

        $response = $next($request);

        // Check if traffic tracking is enabled
        if (config('tracking.traffic.track')) {
            $this->track($request, $response);
        } else {
            $request->attributes->add(['track_traffic_token' => null]);
        }

        return $response;
    }

    /**
     * @param Request                   $request
     * @param Response|RedirectResponse $response
     */
    private function track(Request $request, $response)
    {
        // Fire Traffic Tracker event
        event(new TrackTrafficEvent(
            $request,
            $response,
            $this->getTimestamp(),
        ));
    }

    /**
     * @return string
     */
    private function getTimestamp()
    {
        return microtime(true);
    }
}
