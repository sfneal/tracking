<?php

namespace Sfneal\Tracking\Tests\Feature;

use Sfneal\Testing\Utils\Traits\AssertModelAttributes;
use Sfneal\Tracking\Models\TrackAction;
use Sfneal\Tracking\Models\TrackActivity;
use Sfneal\Tracking\Models\TrackTraffic;
use Sfneal\Tracking\Tests\TestCase;

class MigrationsTest extends TestCase
{
    use AssertModelAttributes;

    /** @test */
    public function track_action_table_is_accessible()
    {
        // Expected data
        $data = [
            'action' => 'Created the model.',
            'trackable_id' => 40,
            'trackable_type' => 'people',
        ];

        // Create the `TrackAction`
        $action = TrackAction::query()->create($data);

        // Retrieve the `TrackAction`
        $newAction = TrackAction::query()->find($action->getKey());

        // Assert model has expected values
        $this->assertModelAttributesSame($data, $newAction);
    }

    /** @test */
    public function track_activity_table_is_accessible()
    {
        // Expected data
        $data = [
            'user_id' => 38,
            'route' => 'people.store',
            'description' => 'Created a new People model.',
            'request_token' => uniqid(),
            'trackable_id' => 22,
            'trackable_type' => 'people',
        ];

        // Create the `TrackActivity` model
        $activity = TrackActivity::query()->create($data);

        // Retrieve the new `TrackActivity` model
        $newActivity = TrackActivity::query()->find($activity->getKey());

        // Assert model has expected values
        $this->assertModelAttributesSame($data, $newActivity);
    }

    /** @test */
    public function track_traffic_table_is_accessible()
    {
        // Expected data
        $data = [
            'user_id' => 38,
            'session_id' => session_id(),
            'app_version' => '3.41.2',
            'app_environment' => 'development',
            'request_host' => 'example.com',
            'request_uri' => 'test',
            'request_method' => 'GET',
            'request_payload' => ['page' => 2],
            'request_ip' => '192.168.150.51',
            'request_token' => uniqid(),
            'response_code' => 200,
            'response_time' => .65,
            'agent_platform' => 'OS X',
            'agent_device' => 'Macintosh',
            'agent_browser' => 'Chrome',
            'time_stamp' => date('Y-m-d H:i:s'),
        ];

        // Create the `TrackActivity` model
        $traffic = TrackTraffic::query()->create($data);

        // Retrieve the new `TrackActivity` model
        $newTraffic = TrackTraffic::query()->find($traffic->getKey());

        // Assert model has expected values
        $this->assertModelAttributesSame($data, $newTraffic);
    }
}
