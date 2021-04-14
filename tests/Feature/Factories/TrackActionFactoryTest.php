<?php

namespace Sfneal\Tracking\Tests\Feature\Factories;

use Sfneal\Tracking\Models\TrackAction;

class TrackActionFactoryTest extends FactoriesTestCase implements FactoryFillablesTest
{
    /**
     * @var TrackAction
     */
    public $modelClass = TrackAction::class;

    /** @test */
    public function fillables_are_correct_types()
    {
        $this->assertIsInt($this->model->getKey());
        $this->assertIsString($this->model->model_table);
        $this->assertIsInt($this->model->model_key);
        $this->assertIsArray($this->model->model_changes);
    }
}