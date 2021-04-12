<?php

namespace Sfneal\Tracking\Tests;

class LaravelConfigTest extends TestCase
{
    /** @test */
    public function config_is_accessible()
    {
        // Confirm the tracking config array exists
        $this->assertIsArray(config('tracking'));
        $this->assertIsArray(config('tracking.traffic'));
    }

    /** @test */
    public function config_tracking_traffic_track()
    {
        $output = config('tracking.traffic.track');
        $expected = true;

        $this->assertIsBool($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function config_tracking_traffic_store()
    {
        $output = config('tracking.traffic.store');
        $expected = true;

        $this->assertIsBool($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function config_tracking_traffic_log()
    {
        $output = config('tracking.traffic.log');
        $expected = false;

        $this->assertIsBool($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function config_tracking_traffic_log_channel()
    {
        $output = config('tracking.traffic.log_channel');
        $expected = 'traffic';

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function config_tracking_traffic_response_content()
    {
        $output = config('tracking.traffic.response_content');
        $expected = false;

        $this->assertIsBool($output);
        $this->assertSame($expected, $output);
    }
}
