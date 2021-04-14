<?php


namespace Sfneal\Tracking\Tests\Feature\Factories;


use Sfneal\Tracking\Models\Base\Tracking;
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

        // Retrieve the People model from an Address model
        $this->model = $this->modelClass::factory()->create();
    }
}
