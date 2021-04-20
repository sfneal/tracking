<?php

namespace Sfneal\Tracking\Tests\Unit;

use Sfneal\Tracking\Jobs\CleanDevTrackingJob;
use Sfneal\Tracking\Models\TrackTraffic;
use Sfneal\Tracking\Tests\TestCase;

class CleanDevTrackingTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Seed TrackTraffic model with 'development' tracking data
        TrackTraffic::factory()
            ->count(250)
            ->create([
                'app_environment' => 'development',
            ]);

        // Seed TrackTraffic model with other tracking data
        TrackTraffic::factory()
            ->count(150)
            ->create([
                'app_environment' => 'production',
            ]);
    }

    private function cleanDevTracking(\Closure $closure)
    {
        // Validate before cleaning
        $expectedBefore = 250;
        $devTrackingRecordsBefore = TrackTraffic::query()->whereEnvironmentDevelopment()->count();
        $this->assertSame($expectedBefore, $devTrackingRecordsBefore);

        // Clean dev tracking data
        $closure();
        $expectedAfter = 0;
        $devTrackingRecordsAfter = TrackTraffic::query()->whereEnvironmentDevelopment()->count();
        $this->assertSame($expectedAfter, $devTrackingRecordsAfter);

        // Confirm 'production' env data hasn't been deleted
        $expectedTotal = 150;
        $totalTrackingRecords = TrackTraffic::query()->count();
        $this->assertSame($expectedTotal, $totalTrackingRecords);
    }

    /** @test */
    public function clean_dev_tracking_with_job()
    {
        $this->cleanDevTracking(function () {
            (new CleanDevTrackingJob())->handle();
        });
    }

    /** @test */
    public function clean_dev_tracking_with_command()
    {
        $this->cleanDevTracking(function () {
            $this->artisan('tracking:clean-dev');
        });
    }
}
