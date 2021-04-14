<?php

namespace Sfneal\Tracking\Tests\Feature\Factories;

use Sfneal\Tracking\Models\TrackActivity;
use Sfneal\Tracking\Tests\Feature\Factories\Interfaces\FactoryFillablesTest;

class TrackActivityFactoryTest extends FactoriesTestCase implements FactoryFillablesTest
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
        $this->assertIsString($this->model->model_table);
        $this->assertIsInt($this->model->model_key);
        $this->assertIsArray($this->model->model_changes);
        $this->assertIsString($this->model->request_token);
    }
}
