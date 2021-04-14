<?php


namespace Sfneal\Tracking\Tests\Feature\Queries;


use Illuminate\Support\Collection;
use Sfneal\Tracking\Models\Base\Tracking;
use Sfneal\Tracking\Tests\TestCase;

class QueriesTestCase extends TestCase
{
    /**
     * @var Tracking
     */
    public $modelClass = Tracking::class;

    /**
     * @var Collection
     */
    public $models;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // Retrieve the People model from an Address model
        $this->models = $this->modelClass::factory()->count(1000)->create();
    }
}
