<?php

namespace Sfneal\Tracking\Tests\Unit;

use Illuminate\Http\Response;
use Sfneal\Tracking\Actions\ParseTraffic;
use Sfneal\Tracking\Tests\CreateRequest;
use Sfneal\Tracking\Tests\TestCase;

class ParseTrafficTest extends TestCase
{
    use CreateRequest;

    /**
     * @var float
     */
    private $timeStamp;

    /**
     * @var array
     */
    private $tracking;

    /**
     * @var Response
     */
    private $response;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('tracking.traffic.response_content', true);

        $this->timeStamp = microtime(true);
        $this->response = response('OK');
        $this->tracking = (new ParseTraffic(
            $this->createRequest([], ['page'=>1]),
            $this->response,
            $this->timeStamp
        ))->execute();
    }

    /** @test */
    public function tracking_attributes_are_correct()
    {
        $this->assertIsArray($this->tracking);
        $this->assertIsInt($this->tracking['user_id']);
        $this->assertIsString($this->tracking['time_stamp']);
        $this->assertSame(date('Y-m-d H:i:s', $this->timeStamp), $this->tracking['time_stamp']);
    }

    /** @test  */
    public function response_content_is_correct()
    {
        $this->assertIsString($this->tracking['response']['content']);
        $this->assertSame($this->response->content(), $this->tracking['response']['content']);
    }

    /** @test */
    public function request_attributes_are_correct()
    {
        $this->assertIsString($this->tracking['request']['host']);
        $this->assertStringContainsString('/', $this->tracking['request']['uri']);
        $this->assertSame('/?page=1', $this->tracking['request']['uri']);
        $this->assertSame('GET', $this->tracking['request']['method']);
        $this->assertIsArray($this->tracking['request']['payload']);
        $this->assertSame(['page'=>1], $this->tracking['request']['payload']);
        $this->assertIsString($this->tracking['request']['ip']);
        $this->assertSame('127.0.0.1', $this->tracking['request']['ip']);
        $this->assertIsString($this->tracking['request']['token']);
    }

    /** @test */
    public function response_attributes_are_correct()
    {
        $this->assertIsInt($this->tracking['response']['code']);
        $this->assertSame(200, $this->tracking['response']['code']);
        $this->assertIsFloat($this->tracking['response']['time']);
    }
}
