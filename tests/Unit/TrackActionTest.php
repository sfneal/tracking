<?php

namespace Sfneal\Tracking\Tests\Unit;

use Sfneal\Testing\Models\People;
use Sfneal\Testing\Utils\Interfaces\CrudModelTest;
use Sfneal\Tracking\Jobs\TrackActionJob;
use Sfneal\Tracking\Models\TrackAction;
use Sfneal\Tracking\Tests\TestCase;

class TrackActionTest extends TestCase implements CrudModelTest
{
    // todo: fix trackable_type assertions to use instanceOf

    /** @test */
    public function records_can_be_created()
    {
        $action = 'Created the model.';
        $trackAction = (new TrackActionJob($action, People::factory()->create()))->handle();

        $this->assertInstanceOf(TrackAction::class, $trackAction);
        $this->assertSame($action, $trackAction->action);
        $this->assertEmpty($trackAction->model_changes);
        $this->assertSame(People::getTableName(), $trackAction->trackable_type);
    }

    /** @test */
    public function records_can_be_updated()
    {
        $action = 'Created the model.';
        $trackAction = (new TrackActionJob($action, People::factory()->create()))->handle();

        $newAction = 'Created the People model.';
        $trackAction->update([
            'action' => $newAction,
        ]);

        $this->assertInstanceOf(TrackAction::class, $trackAction);
        $this->assertSame($newAction, $trackAction->action);
        $this->assertTrue($trackAction->wasUpdated());
    }

    /** @test */
    public function records_can_be_deleted()
    {
        $action = 'Created the model.';
        $trackAction = (new TrackActionJob($action, People::factory()->create()))->handle();

        $trackAction->delete();

        $this->assertInstanceOf(TrackAction::class, $trackAction);
        $this->assertTrue($trackAction->wasDeleted());
        $this->assertNull(TrackAction::query()->find($trackAction->getKey()));
    }
}
