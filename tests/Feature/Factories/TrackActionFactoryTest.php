<?php

namespace Sfneal\Tracking\Tests\Feature\Factories;

use Sfneal\Testing\Utils\Interfaces\Factory\FillablesTest;
use Sfneal\Tracking\Models\TrackAction;

class TrackActionFactoryTest extends FactoriesTestCase implements FillablesTest
{
    /**
     * @var TrackAction
     */
    public $modelClass = TrackAction::class;

    /** @test */
    public function fillables_are_correct_types()
    {
        $this->assertIsInt($this->model->getKey());
        $this->assertIsArray($this->model->model_changes);
        $this->assertIsInt($this->model->trackable_id);
        $this->assertIsString($this->model->trackable_type);
        // todo: add is instance test for trackable_type
    }
}
