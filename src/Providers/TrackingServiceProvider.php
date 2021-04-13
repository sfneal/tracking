<?php

namespace Sfneal\Tracking\Providers;

use Illuminate\Support\ServiceProvider;

class TrackingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any Tracking services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config file (before migrations in case config values are used in migrations)
        $this->publishes([
            __DIR__.'/../../config/tracking.php' => config_path('tracking.php'),
        ], 'config');

        // `TrackActivity` migration file
        if (! class_exists('CreateTrackActionTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_track_action_table.php.stub' => database_path(
                    'migrations/'.date('Y_m_d_His', time()).'_create_track_action_table.php'
                ),
            ], 'migration');
        }

        // `TrackAction` migration file
        if (! class_exists('CreateTrackActivityTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_track_activity_table.php.stub' => database_path(
                    'migrations/'.date('Y_m_d_His', time()).'_create_track_activity_table.php'
                ),
            ], 'migration');
        }

        // `TrackTraffic` migration file
        if (! class_exists('CreateTrackTrafficTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_track_traffic_table.php.stub' => database_path(
                    'migrations/'.date('Y_m_d_His', time()).'_create_track_traffic_table.php'
                ),
            ], 'migration');
        }
    }

    /**
     * Register any Tracking services.
     *
     * @return void
     */
    public function register()
    {
        // Load config file
        $this->mergeConfigFrom(__DIR__.'/../../config/tracking.php', 'tracking');

        // Register Event ServiceProvider
        $this->app->register(TrackingEventServiceProvider::class);
    }
}
