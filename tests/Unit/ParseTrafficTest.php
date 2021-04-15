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
     * @var ParseTraffic
     */
    private $parser;

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
        $this->parser = new ParseTraffic(
            $this->createRequest([], ['page'=>1]),
            $this->response,
            $this->timeStamp
        );
    }

    /** @test */
    public function tracking_attributes_are_correct()
    {
        $tracking = $this->parser->execute();

        $this->assertIsArray($tracking);
        $this->assertIsInt($tracking['user_id']);
        $this->assertIsString($tracking['time_stamp']);
        $this->assertSame(date('Y-m-d H:i:s', $this->timeStamp), $tracking['time_stamp']);
    }

    /** @test  */
    public function response_content_is_correct()
    {
        $tracking = $this->parser->execute();

        $this->assertIsString($tracking['response']['content']);
        $this->assertSame($this->response->content(), $tracking['response']['content']);
    }

    /** @test */
    public function request_attributes_are_correct()
    {
        $tracking = $this->parser->execute();

        $this->assertIsString($tracking['request']['host']);
        $this->assertStringContainsString('/', $tracking['request']['uri']);
        $this->assertSame('/?page=1', $tracking['request']['uri']);
        $this->assertSame('GET', $tracking['request']['method']);
        $this->assertIsArray($tracking['request']['payload']);
        $this->assertSame(['page'=>1], $tracking['request']['payload']);
        $this->assertIsString($tracking['request']['ip']);
        $this->assertSame('127.0.0.1', $tracking['request']['ip']);
        $this->assertIsString($tracking['request']['token']);
    }

    /** @test */
    public function response_attributes_are_correct()
    {
        $tracking = $this->parser->execute();

        $this->assertIsInt($tracking['response']['code']);
        $this->assertSame(200, $tracking['response']['code']);
        $this->assertIsFloat($tracking['response']['time']);
    }
}
