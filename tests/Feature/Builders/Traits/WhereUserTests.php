<?php


namespace Sfneal\Tracking\Tests\Feature\Builders\Traits;


trait WhereUserTests
{
    /** @test */
    public function whereUser()
    {
        $expected = 1;

        $user_id = $this->modelClass::query()
            ->distinct()
            ->get('user_id')
            ->shuffle()
            ->take($expected)
            ->pluck('user_id')
            ->first();

        $model = $this->modelClass::query()->whereUser($user_id)->get();

        $this->assertContains($user_id, $model->pluck('user_id'));
    }

    /** @test */
    public function whereUsers()
    {
        $expected = 3;

        $user_ids = $this->modelClass::query()
            ->distinct()
            ->get('user_id')
            ->shuffle()
            ->take($expected)
            ->pluck('user_id')
            ->toArray();

        $models = $this->modelClass::query()->whereUserIn($user_ids)->get();

        foreach ($user_ids as $user_id) {
            $this->assertContains($user_id, $models->pluck('user_id'));
        }
    }
}
