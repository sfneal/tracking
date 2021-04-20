<?php

namespace Sfneal\Tracking\Tests\Feature\Queries;

use Illuminate\Support\Collection;
use Sfneal\Testing\Utils\Traits\CreateRequest;
use Sfneal\Tracking\Models\Base\Tracking;
use Sfneal\Tracking\Tests\TestCase;

class QueriesTestCase extends TestCase
{
    use CreateRequest;

    /**
     * @var Tracking
     */
    public $modelClass = Tracking::class;

    /**
     * @var Collection
     */
    public $models;

    /**
     * @var int
     */
    public $count = 1000;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // Retrieve the People model from an Address model
        $this->models = $this->modelClass::factory()->count($this->count)->create();
    }
}
