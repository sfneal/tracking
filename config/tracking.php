<?php

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
        'track' => false,

        /*
        |--------------------------------------------------------------------------
        | Track Traffic database storage
        |--------------------------------------------------------------------------
        |
        | Enable storing of tracked traffic data using the `TrackTraffic` model.
        |
        | type     : boolean
        | default  : false
        |
        */
        'store' => false,

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
        'log' => false,

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
        'response_content' => false,
    ],

];
