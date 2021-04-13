<?php


namespace Sfneal\Tracking\Tests\Actions;


use Sfneal\Tracking\Actions\CleanDevTrackingAction;
use Sfneal\Tracking\Models\TrackTraffic;
use Sfneal\Tracking\Tests\TestCase;

class CleanDevTrackingActionTest extends TestCase
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
                'app_environment' => 'development'
            ]);

        // Seed TrackTraffic model with other tracking data
        TrackTraffic::factory()
            ->count(150)
            ->create([
                'app_environment' => 'production'
            ]);
    }

    /** @test */
    public function dev_tracking_can_be_cleaned()
    {
        // Validate before cleaning
        $expectedBefore = 250;
        $devTrackingRecordsBefore = TrackTraffic::query()->whereEnvironment('development')->count();
        $this->assertSame($expectedBefore, $devTrackingRecordsBefore);

        // Clean dev tracking data
        CleanDevTrackingAction::execute();
        $expectedAfter = 0;
        $devTrackingRecordsAfter = TrackTraffic::query()->whereEnvironment('development')->count();
        $this->assertSame($expectedAfter, $devTrackingRecordsAfter);

        // Confirm 'production' env data hasn't been deleted
        $expectedTotal = 150;
        $totalTrackingRecords = TrackTraffic::query()->count();
        $this->assertSame($expectedTotal, $totalTrackingRecords);
    }
}
