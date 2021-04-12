<?php

namespace Sfneal\Tracking\Providers;

use Illuminate\Support\ServiceProvider;

class TrackingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish migration file (if not already published)
        // `TrackActivity` migration
        if (! class_exists('CreateTrackActionTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_track_action_table.php.stub' => database_path(
                    'migrations/'.date('Y_m_d_His', time()).'_create_track_action_table.php'
                ),
            ], 'migration');
        }

        // `TrackAction` migration
        if (! class_exists('CreateTrackActivityTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_track_activity_table.php.stub' => database_path(
                    'migrations/'.date('Y_m_d_His', time()).'_create_track_activity_table.php'
                ),
            ], 'migration');
        }

        // `TrackTraffic` migration
        if (! class_exists('CreateTrackTrafficTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_track_traffic_table.php.stub' => database_path(
                    'migrations/'.date('Y_m_d_His', time()).'_create_track_traffic_table.php'
                ),
            ], 'migration');
        }
    }
}
