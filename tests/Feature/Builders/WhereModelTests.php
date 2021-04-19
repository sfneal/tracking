<?php

namespace Sfneal\Tracking\Tests\Feature\Builders;

use Sfneal\Queries\RandomModelAttributeQuery;

trait WhereModelTests
{
    /** @test */
    public function whereModelKey()
    {
        $model_key = (new RandomModelAttributeQuery($this->modelClass, 'model_key'))->execute();

        $model = $this->modelClass::query()->whereModelKey($model_key)->get();

        $this->assertContains($model_key, $model->pluck('model_key'));
    }

    /** @test */
    public function whereModelKeyMultiple()
    {
        $take = 4;
        $model_keys = (new RandomModelAttributeQuery($this->modelClass, 'model_key', $take))->execute();

        $models = $this->modelClass::query()->whereModelKey($model_keys)->get();

        foreach ($model_keys as $model_key) {
            $this->assertContains($model_key, $models->pluck('model_key'));
        }
    }

    /** @test */
    public function whereModelTable()
    {
        $model_table = (new RandomModelAttributeQuery($this->modelClass, 'model_table'))->execute();

        $models = $this->modelClass::query()->whereModelTable($model_table)->get();

        $this->assertContains($model_table, $models->pluck('model_table'));
    }
}
