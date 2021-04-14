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

        $count = $this->modelClass::query()->whereModelKey($model_key)->count();

        $this->assertSame($expected, $count);
    }

    /** @test */
    public function whereModelKeyMultiple()
    {
        $expected = 4;

        $model_key = $this->modelClass::query()
            ->distinct()
            ->get('model_key')
            ->shuffle()
            ->take($expected)
            ->pluck('model_key')
            ->toArray();

        $count = $this->modelClass::query()->whereModelKey($model_key)->count();

        $this->assertSame($expected, $count);
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
