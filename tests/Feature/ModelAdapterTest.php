<?php

namespace Sfneal\Tracking\Tests\Feature;

use Sfneal\Tracking\Models\TrackAction;
use Sfneal\Tracking\Models\TrackActivity;
use Sfneal\Tracking\Models\TrackTraffic;
use Sfneal\Tracking\Tests\TestCase;
use Sfneal\Tracking\Utils\ModelAdapter;

class ModelAdapterTest extends TestCase
{
    /**
     * Execute assertions to confirm that the Model provided by the ModelAdapter is correct.
     *
     * @param $expected
     * @param $model
     *
     * @return void
     */
    private function executeAssertions($expected, $model): void
    {
        $this->assertIsString($model);
        $this->assertInstanceOf($expected, new $model());
        $this->assertSame($expected, $model);
        $this->assertSame(get_class(new $expected()), get_class(new $model()));
        $this->assertSame(get_class_methods(new $expected()), get_class_methods(new $model()));
    }

    /** @test */
    public function track_action_model_is_accessible()
    {
        $expected = TrackAction::class;
        $model = ModelAdapter::TrackAction();

        $this->executeAssertions($expected, $model);
    }

    /** @test */
    public function track_activity_model_is_accessible()
    {
        $expected = TrackActivity::class;
        $model = ModelAdapter::TrackActivity();

        $this->executeAssertions($expected, $model);
    }

    /** @test */
    public function track_traffic_model_is_accessible()
    {
        $expected = TrackTraffic::class;
        $model = ModelAdapter::TrackTraffic();

        $this->executeAssertions($expected, $model);
    }
}
