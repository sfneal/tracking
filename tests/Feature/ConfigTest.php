<?php


namespace Sfneal\Tracking\Tests\Feature;


use Sfneal\Tracking\Models\TrackAction;
use Sfneal\Tracking\Models\TrackActivity;
use Sfneal\Tracking\Models\TrackTraffic;
use Sfneal\Tracking\Tests\TestCase;

class ConfigTest extends TestCase
{
    /** @test */
    public function config_is_accessible()
    {
        // Confirm the tracking config arrays exists
        $this->assertIsArray(config('tracking'));
        $this->assertIsArray(config('tracking.traffic'));
        $this->assertIsArray(config('tracking.models'));
    }

    /** @test */
    public function traffic_track()
    {
        $output = config('tracking.traffic.track');

        $this->assertIsBool($output);
        $this->assertTrue($output);
    }

    /** @test */
    public function traffic_store()
    {
        $output = config('tracking.traffic.store');

        $this->assertIsBool($output);
        $this->assertTrue($output);
    }

    /** @test */
    public function traffic_log()
    {
        $output = config('tracking.traffic.log');

        $this->assertIsBool($output);
        $this->assertFalse($output);
    }

    /** @test */
    public function traffic_log_channel()
    {
        $expected = 'traffic';
        $output = config('tracking.traffic.log_channel');

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function traffic_response_content()
    {
        $output = config('tracking.traffic.response_content');

        $this->assertIsBool($output);
        $this->assertFalse($output);
    }

    /** @test */
    public function models_TrackAction()
    {
        $expected = TrackAction::class;
        $output = config('tracking.models.TrackAction');

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function models_TrackActivity()
    {
        $expected = TrackActivity::class;
        $output = config('tracking.models.TrackActivity');

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function models_TrackTraffic()
    {
        $expected = TrackTraffic::class;
        $output = config('tracking.models.TrackTraffic');

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function queue()
    {
        $expected = 'default';
        $output = config('tracking.queue');

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function driver()
    {
        $expected = config('queue.default');
        $output = config('tracking.driver');

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }
}
