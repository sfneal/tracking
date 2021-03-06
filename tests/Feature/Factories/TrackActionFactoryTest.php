<?php

namespace Sfneal\Tracking\Tests\Feature\Factories;

use Sfneal\Address\Models\Address;
use Sfneal\Testing\Models\People;
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
        $this->assertContains($this->model->trackable_type, [People::class, Address::class]);
        $this->assertInstanceOf($this->model->trackable_type, $this->model->trackable);
    }
}
