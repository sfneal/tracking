<?php


namespace Sfneal\Tracking\Tests\Feature\Builders;


use Sfneal\Tracking\Models\Base\Tracking;
use Sfneal\Tracking\Tests\TestCase;

class BuilderTestCase extends TestCase
{
    /**
     * @var Tracking
     */
    protected $modelClass = Tracking::class;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->modelClass::factory()
            ->count(50)
            ->create();
    }

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

        $count = $this->modelClass::query()->whereUser($user_id)->count();

        $this->assertSame($expected, $count);
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

        $count = $this->modelClass::query()->whereUserIn($user_ids)->count();

        $this->assertSame($expected, $count);
    }
}
