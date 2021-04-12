<?php

namespace Sfneal\Tracking\Tests;

use Sfneal\Tracking\Models\TrackAction;
use Sfneal\Tracking\Models\TrackActivity;
use Sfneal\Tracking\Models\TrackTraffic;

class MigrationsTest extends TestCase
{
    /** @test */
    public function track_action_table_is_accessible()
    {
        // Expected data
        $data = [
            'action' => 'Created the model.',
            'model_table' => 'people',
            'model_key' => 40,
        ];

        // Create the `TrackAction`
        $action = TrackAction::query()->create($data);

        // Retrieve the `TrackAction`
        $newAction = TrackAction::query()->find($action->getKey());

        // Assert model has expected values
        $this->assertSame($data['action'], $newAction->action);
        $this->assertSame($data['model_table'], $newAction->model_table);
        $this->assertSame($data['model_key'], $newAction->model_key);
    }

    /** @test */
    public function track_activity_table_is_accessible()
    {
        // Expected data
        $data = [
            'user_id' => 38,
            'route' => 'people.store',
            'description' => 'Created a new People model.',
            'model_table' => 'people',
            'model_key' => 22,
            'request_token' => uniqid(),
        ];

        // Create the `TrackActivity` model
        $activity = TrackActivity::query()->create($data);

        // Retrieve the new `TrackActivity` model
        $newActivity = TrackActivity::query()->find($activity->getKey());

        // Assert model has expected values
        $this->assertSame($data['user_id'], $newActivity->user_id);
        $this->assertSame($data['route'], $newActivity->route);
        $this->assertSame($data['description'], $newActivity->description);
        $this->assertSame($data['model_table'], $newActivity->model_table);
        $this->assertSame($data['model_key'], $newActivity->model_key);
        $this->assertSame($data['request_token'], $newActivity->request_token);
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
        $this->assertSame($data['user_id'], $newTraffic->user_id);
        $this->assertSame($data['session_id'], $newTraffic->session_id);
        $this->assertSame($data['app_version'], $newTraffic->app_version);
        $this->assertSame($data['app_environment'], $newTraffic->app_environment);
        $this->assertSame($data['request_host'], $newTraffic->request_host);
        $this->assertSame($data['request_uri'], $newTraffic->request_uri);
        $this->assertSame($data['request_method'], $newTraffic->request_method);
        $this->assertSame($data['request_payload'], $newTraffic->request_payload);
        $this->assertSame($data['request_ip'], $newTraffic->request_ip);
        $this->assertSame($data['request_token'], $newTraffic->request_token);
        $this->assertSame($data['response_code'], $newTraffic->response_code);
        $this->assertSame($data['response_time'], $newTraffic->response_time);
        $this->assertSame($data['agent_platform'], $newTraffic->agent_platform);
        $this->assertSame($data['agent_device'], $newTraffic->agent_device);
        $this->assertSame($data['agent_browser'], $newTraffic->agent_browser);
        $this->assertSame($data['time_stamp'], $newTraffic->time_stamp);
    }
}
