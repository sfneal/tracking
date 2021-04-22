<?php

namespace Sfneal\Tracking\Tests\Feature\Builders;

use Sfneal\Queries\RandomModelAttributeQuery;

trait WhereModelTests
{
    /** @test */
    public function whereTrackableId()
    {
        $trackable_id = (new RandomModelAttributeQuery($this->modelClass, 'trackable_id'))->execute();

        $model = $this->modelClass::query()->whereTrackableId($trackable_id)->get();

        $this->assertContains($trackable_id, $model->pluck('trackable_id'));
    }

    /** @test */
    public function whereTrackableIdMultiple()
    {
        $take = 4;
        $trackable_ids = (new RandomModelAttributeQuery($this->modelClass, 'trackable_id', $take))->execute();

        $models = $this->modelClass::query()->whereTrackableId($trackable_ids)->get();

        foreach ($trackable_ids as $trackable_id) {
            $this->assertContains($trackable_id, $models->pluck('trackable_id'));
        }
    }

    /** @test */
    public function whereTrackableType()
    {
        $trackable_type = (new RandomModelAttributeQuery($this->modelClass, 'trackable_type'))->execute();

        $models = $this->modelClass::query()->whereTrackableType($trackable_type)->get();

        $this->assertContains($trackable_type, $models->pluck('trackable_type'));
    }
}
