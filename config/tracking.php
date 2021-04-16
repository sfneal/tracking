<?php

use Sfneal\Tracking\Models\TrackAction;
use Sfneal\Tracking\Models\TrackActivity;
use Sfneal\Tracking\Models\TrackTraffic;

return [
    'traffic' => [
        /*
        |--------------------------------------------------------------------------
        | Track Traffic
        |--------------------------------------------------------------------------
        |
        | Enable traffic tracking within your laravel application.  Once enable
        | along with 'store' key, visits to routes using the
        | `TrackTrafficMiddleware` will be tracked & data will be stored using a
        | `TrackTraffic` model.
        |
        | type     : boolean
        | default  : false
        |
        */
        'track' => env('TRACK_TRAFFIC', false),

        /*
        |--------------------------------------------------------------------------
        | Track Traffic database storage
        |--------------------------------------------------------------------------
        |
        | Enable storing of tracked traffic data using the `TrackTraffic` model.
        |
        | type     : boolean
        | default  : true
        |
        */
        'store' => true,

        /*
        |--------------------------------------------------------------------------
        | Track Traffic Logging
        |--------------------------------------------------------------------------
        |
        | Enable logging of tracked traffic data to a log file.
        |  - requires 'track_traffic' is also enabled
        |
        | type     : boolean
        | default  : false
        |
        */
        'log' => env('TRACK_TRAFFIC_LOGGING', false),

        /*
        |--------------------------------------------------------------------------
        | Track Traffic log channel
        |--------------------------------------------------------------------------
        |
        | Set the name of the log channel to use when logging traffic tracking
        | data.  Default value of 'traffic' requires creating a log file with that
        | name within your application
        |
        | type     : string
        | default  : 'traffic'
        |
        */
        'log_channel' => 'traffic',

        /*
        |--------------------------------------------------------------------------
        | Response Content tracking
        |--------------------------------------------------------------------------
        |
        | Enable storing response content within tracked traffic data.
        | WARNING enabling this option can cause significant performance degradation.
        |
        | type     : boolean
        | default  : false
        |
        */
        'response_content' => env('TRACK_TRAFFIC_RESPONSE_CONTENT', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Model Overrides
    |--------------------------------------------------------------------------
    |
    | Specify custom Models that extend built-in sfneal/tracking models to add
    | custom methods & relationships.
     */
    'models' => [
        /*
        |--------------------------------------------------------------------------
        | 'TrackAction' model
        |--------------------------------------------------------------------------
        |
        | Use a custom extension of the `TrackAction` model within your application
        |
        | type     : TrackAction model or extended model
        | default  : TrackAction::class
        |
        */
        'TrackAction' => TrackAction::class,

        /*
        |--------------------------------------------------------------------------
        | 'TrackActivity' model
        |--------------------------------------------------------------------------
        |
        | Use a custom extension of the `TrackActivity` model within your application
        |
        | type     : TrackActivity model or extended model
        | default  : TrackActivity::class
        |
        */
        'TrackActivity' => TrackActivity::class,

        /*
        |--------------------------------------------------------------------------
        | 'TrackTraffic' model
        |--------------------------------------------------------------------------
        |
        | Use a custom extension of the `TrackTraffic` model within your application
        |
        | type     : TrackTraffic model or extended model
        | default  : TrackTraffic::class
        |
        */
        'TrackTraffic' => TrackTraffic::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tracking Jobs Queue
    |--------------------------------------------------------------------------
    |
    | Specify a Job queue to use when dispatching tracking jobs.  Creating a
    | 'tracking' queue can be effective for avoiding bottlenecks.
    |
    | type     : string
    | default  : 'default'
    |
    */
    'queue' => env('TRACKING_QUEUE', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Default Queue Driver
    |--------------------------------------------------------------------------
    |
    | Specify a Queue Driver for dispatching tracking jobs.
    |
    */
    'driver' => env('TRACKING_QUEUE_DRIVER', config('queue.default')),

];
