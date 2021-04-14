<?php


namespace Sfneal\Tracking\Tests\Feature;


use Illuminate\Support\Facades\Queue;
use Sfneal\Testing\Models\People;
use Sfneal\Tracking\Jobs\CleanDevTrackingJob;
use Sfneal\Tracking\Jobs\TrackActionJob;
use Sfneal\Tracking\Jobs\TrackActivityJob;
use Sfneal\Tracking\Tests\TestCase;

class JobsTest extends TestCase
{
    /** @test */
    public function clean_dev_tracking_job_can_be_queued()
    {
        // Enable queue faking
        Queue::fake();

        // Assert that no jobs were pushed...
        Queue::assertNothingPushed();

        // Dispatch the first job...
        Queue::push(CleanDevTrackingJob::class);

        // Assert a job was pushed...
        Queue::assertPushed(CleanDevTrackingJob::class, 1);
    }

    /** @test */
    public function track_action_job_can_be_queued()
    {
        // Enable queue faking
        Queue::fake();

        // Assert that no jobs were pushed...
        Queue::assertNothingPushed();

        // Dispatch the first job...
        Queue::push(new TrackActionJob('Updated the model.', People::factory()->create()));

        // Assert a job was pushed...
        Queue::assertPushed(TrackActionJob::class, 1);
    }

    /** @test */
    public function track_activity_job_can_be_queued()
    {
        // Enable queue faking
        Queue::fake();

        // Assert that no jobs were pushed...
        Queue::assertNothingPushed();

        // Dispatch the first job...
        Queue::push(new TrackActivityJob(
            People::factory()->create(),
            uniqid(),
            random_int(1, 999),
            '/'
        ));

        // Assert a job was pushed...
        Queue::assertPushed(TrackActivityJob::class, 1);
    }
}
