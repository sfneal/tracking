<?php

namespace Sfneal\Tracking\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sfneal\Testing\Providers\MockModelsServiceProvider;
use Sfneal\Tracking\Providers\TrackingServiceProvider;

class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    // todo: refactor database seeding to use seeder classes

    /**
     * Register package service providers.
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            TrackingServiceProvider::class,
            MockModelsServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        if (! defined('LARAVEL_START')) {
            define('LARAVEL_START', microtime(true));
        }

        // Set config values
        $app['config']->set('app.debug', true);
        $app['config']->set('tracking.traffic.track', true);

        // Migrate 'track_action' table
        include_once __DIR__.'/../database/migrations/create_track_action_table.php.stub';
        (new \CreateTrackActionTable())->up();

        // Migrate 'track_activity' table
        include_once __DIR__.'/../database/migrations/create_track_activity_table.php.stub';
        (new \CreateTrackActivityTable())->up();

        // Migrate 'track_traffic' table
        include_once __DIR__.'/../database/migrations/create_track_traffic_table.php.stub';
        (new \CreateTrackTrafficTable())->up();

        // Migrate 'people' table
        include_once __DIR__.'/../vendor/sfneal/mock-models/database/migrations/create_people_table.php.stub';
        (new \CreatePeopleTable())->up();

        // Migrate 'address table
        include_once __DIR__.'/../vendor/sfneal/address/database/migrations/create_address_table.php.stub';
        (new \CreateAddressTable())->up();
    }
}
