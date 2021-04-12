<?php


namespace Sfneal\Tracking\Tests;


use Sfneal\Tracking\Models\TrackAction;

class MigrationsTest extends TestCase
{
    /** @test */
    public function track_action_table_is_accessible()
    {
        // Expected
        $actionText = 'Created the model.';
        $model_table = 'people';
        $model_key = 40;

        // Save the `TrackAction`
        $action = new TrackAction();
        $action->action = $actionText;
        $action->model_table = $model_table;
        $action->model_key = $model_key;
        $action->save();

        // Retrieve the `TrackAction`
        $newAction = TrackAction::query()->find($action->getKey());

        // Assert model has expected values
        $this->assertSame($actionText, $newAction->action);
        $this->assertSame($model_table, $newAction->model_table);
        $this->assertSame($model_key, $newAction->model_key);
    }
}
