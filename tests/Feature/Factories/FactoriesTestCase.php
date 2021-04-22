<?php

namespace Sfneal\Tracking\Tests\Feature\Factories;

use Sfneal\Testing\Models\People;
use Sfneal\Tracking\Models\Base\Tracking;
use Sfneal\Tracking\Models\TrackTraffic;
use Sfneal\Tracking\Tests\TestCase;

class FactoriesTestCase extends TestCase
{
    /**
     * @var Tracking
     */
    public $modelClass = Tracking::class;

    /**
     * @var Tracking
     */
    public $model;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $factory = $this->modelClass::factory();

        // Add polymorphic relationships for `TrackAction` & `TrackActivity`
        if ($this->modelClass != TrackTraffic::class) {
            $factory->for(People::factory(), 'trackable');
        }

        // Create models from the factory
        $this->model = $factory->create();
    }
}
