<?php


namespace Sfneal\Tracking\Tests;


use Sfneal\Tracking\Models\TrackAction;
use Sfneal\Tracking\Models\TrackActivity;

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
            'request_token' => uniqid()
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
}
