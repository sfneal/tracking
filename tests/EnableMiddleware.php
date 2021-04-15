<?php


namespace Sfneal\Tracking\Tests;


use Illuminate\Support\Facades\Route;
use Sfneal\Tracking\Middleware\TrackTrafficMiddleware;

trait EnableMiddleware
{
    /**
     * Enable TrackTraffic middleware.
     *
     * @return void
     */
    protected function enableMiddleware(): void
    {
        // Enable middleware
        Route::middleware(TrackTrafficMiddleware::class)->any('/', function () {
            return 'OK';
        });
    }
}
