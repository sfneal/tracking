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
}
