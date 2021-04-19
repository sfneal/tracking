<?php

namespace Sfneal\Tracking\Tests\Unit;

use Sfneal\Testing\Models\People;
use Sfneal\Tracking\Actions\TrackActivityAction;
use Sfneal\Tracking\Actions\TrackTrafficAction;
use Sfneal\Tracking\Events\TrackTrafficEvent;
use Sfneal\Tracking\Models\TrackActivity;
use Sfneal\Tracking\Models\TrackTraffic;
use Sfneal\Tracking\Tests\CreateRequest;
use Sfneal\Tracking\Tests\CrudModelTest;
use Sfneal\Tracking\Tests\TestCase;

class TrackActivityTest extends TestCase implements CrudModelTest
{
    use CreateRequest;

    /** @test */
    public function records_can_be_created()
    {
        $model = People::factory()->create();
        $user_id = rand(1, 999);
        $route = 'people.create';
        $activity = (new TrackActivityAction(
            $model,
            uniqid(),
            $user_id,
            $route
        ))->execute();

        $this->assertInstanceOf(TrackActivity::class, $activity);
        $this->assertSame($user_id, $activity->user_id);
        $this->assertSame($route, $activity->route);
        $this->assertNull($activity->description);
        $this->assertSame(People::getTableName(), $activity->model_table);
        $this->assertSame($model->getKey(), $activity->model_key);
        $this->assertEmpty($activity->model_changes);
    }

    /** @test */
    public function records_can_be_created_with_tracking()
    {
        $trackingData = (new TrackTrafficEvent(
            $this->createRequest(),
            response('OK'),
            microtime(true)
        ))->tracking;

        $traffic = (new TrackTrafficAction($trackingData))->execute();

        $model = People::factory()->create();
        $user_id = rand(1, 999);
        $route = 'people.create';
        $activity = (new TrackActivityAction(
            $model,
            $traffic->request_token,
            $user_id,
            $route
        ))->execute();

        $this->assertInstanceOf(TrackActivity::class, $activity);
        $this->assertSame($user_id, $activity->user_id);
        $this->assertSame($route, $activity->route);
        $this->assertNull($activity->description);
        $this->assertSame(People::getTableName(), $activity->model_table);
        $this->assertSame($model->getKey(), $activity->model_key);
        $this->assertEmpty($activity->model_changes);

        $this->assertInstanceOf(TrackTraffic::class, $activity->tracking);
        $this->assertSame($traffic->request_token, $activity->request_token);
    }

    /** @test */
    public function records_can_be_updated()
    {
        $model = People::factory()->create();
        $user_id = rand(1, 999);
        $route = 'people.create';
        $activity = (new TrackActivityAction(
            $model,
            uniqid(),
            $user_id,
            $route
        ))->execute();

        $description = 'Updated the People model with latest attributes.';
        $activity->update([
            'description' => $description,
        ]);

        $this->assertInstanceOf(TrackActivity::class, $activity);
        $this->assertSame($description, $activity->description);
        $this->assertTrue($activity->wasUpdated());
    }

    /** @test */
    public function records_can_be_deleted()
    {
        $model = People::factory()->create();
        $user_id = rand(1, 999);
        $route = 'people.create';
        $activity = (new TrackActivityAction(
            $model,
            uniqid(),
            $user_id,
            $route
        ))->execute();

        $activity->delete();

        $this->assertInstanceOf(TrackActivity::class, $activity);
        $this->assertTrue($activity->wasDeleted());
        $this->assertNull(TrackActivity::query()->find($activity->getKey()));
    }
}
