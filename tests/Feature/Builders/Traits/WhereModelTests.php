<?php


namespace Sfneal\Tracking\Tests\Feature\Builders\Traits;


trait WhereModelTests
{
    /** @test */
    public function whereModelKey()
    {
        $expected = 1;

        $model_key = $this->modelClass::query()
            ->distinct()
            ->get('model_key')
            ->shuffle()
            ->take($expected)
            ->pluck('model_key')
            ->first();

        $model = $this->modelClass::query()->whereModelKey($model_key)->get();

        $this->assertContains($model_key, $model->pluck('model_key'));
    }

    /** @test */
    public function whereModelKeyMultiple()
    {
        $expected = 4;

        $model_keys = $this->modelClass::query()
            ->distinct()
            ->get('model_key')
            ->shuffle()
            ->take($expected)
            ->pluck('model_key')
            ->toArray();

        $models = $this->modelClass::query()->whereModelKey($model_keys)->get();

        foreach ($model_keys as $model_key) {
            $this->assertContains($model_key, $models->pluck('model_key'));
        }
    }

    /** @test */
    public function whereModelTable()
    {
        $expected = 50;

        $model_key = $this->modelClass::query()
            ->distinct()
            ->get('model_table')
            ->shuffle()
            ->take($expected)
            ->pluck('model_table')
            ->first();

        $count = $this->modelClass::query()->whereModelTable($model_key)->count();

        $this->assertSame($expected, $count);
    }
}
