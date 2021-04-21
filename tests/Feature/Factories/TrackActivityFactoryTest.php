<?php

namespace Sfneal\Tracking\Tests\Feature\Factories;

use Sfneal\Address\Models\Address;
use Sfneal\Testing\Models\People;
use Sfneal\Testing\Utils\Interfaces\Factory\FillablesTest;
use Sfneal\Tracking\Models\TrackActivity;

class TrackActivityFactoryTest extends FactoriesTestCase implements FillablesTest
{
    /**
     * @var TrackActivity
     */
    public $modelClass = TrackActivity::class;

    /** @test */
    public function fillables_are_correct_types()
    {
        $this->assertIsInt($this->model->getKey());
        $this->assertIsInt($this->model->user_id);
        $this->assertIsString($this->model->route);
        $this->assertIsString($this->model->description);
        $this->assertIsArray($this->model->model_changes);
        $this->assertIsString($this->model->request_token);
        $this->assertIsInt($this->model->trackable_id);
        $this->assertIsString($this->model->trackable_type);
        $this->assertContains($this->model->trackable_type, [People::class, Address::class]);
        $this->assertInstanceOf($this->model->trackable_type, $this->model->trackable);
    }
}
