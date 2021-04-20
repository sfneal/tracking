<?php

namespace Sfneal\Tracking\Tests\Unit;

use Sfneal\Testing\Utils\Interfaces\CrudModelTest;
use Sfneal\Testing\Utils\Traits\CreateRequest;
use Sfneal\Tracking\Actions\TrackTrafficAction;
use Sfneal\Tracking\Events\TrackTrafficEvent;
use Sfneal\Tracking\Models\TrackTraffic;
use Sfneal\Tracking\Tests\TestCase;

class TrackTrafficTest extends TestCase implements CrudModelTest
{
    use CreateRequest;

    /** @test */
    public function records_can_be_created()
    {
        $trackingData = (new TrackTrafficEvent(
            $this->createRequest(),
            response('OK'),
            microtime(true)
        ))->tracking;

        $traffic = (new TrackTrafficAction($trackingData))->execute();

        $this->assertInstanceOf(TrackTraffic::class, $traffic);
        $this->assertEquals('testing', $traffic->app_environment);
        $this->assertEquals('GET', $traffic->request_method);
    }

    /** @test */
    public function records_can_be_updated()
    {
        $trackingData = (new TrackTrafficEvent(
            $this->createRequest(),
            response('OK'),
            microtime(true)
        ))->tracking;

        $traffic = (new TrackTrafficAction($trackingData))->execute();
        $traffic->update([
            'app_environment' => 'development',
            'request_method' => 'post',
        ]);

        $this->assertInstanceOf(TrackTraffic::class, $traffic);
        $this->assertEquals('development', $traffic->app_environment);
        $this->assertEquals('POST', $traffic->request_method);
    }

    /** @test */
    public function records_can_be_deleted()
    {
        $trackingData = (new TrackTrafficEvent(
            $this->createRequest(),
            response('OK'),
            microtime(true)
        ))->tracking;

        $traffic = (new TrackTrafficAction($trackingData))->execute();

        $traffic->delete();

        $this->assertInstanceOf(TrackTraffic::class, $traffic);
        $this->assertTrue($traffic->wasDeleted());
        $this->assertNull(TrackTraffic::query()->find($traffic->getKey()));
    }
}
