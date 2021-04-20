<?php

namespace Sfneal\Tracking\Tests\Unit;

use Illuminate\Http\Response;
use Sfneal\Testing\Utils\Traits\CreateRequest;
use Sfneal\Tracking\Actions\ParseTraffic;
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

    /** @test */
    public function request_attributes_are_correct()
    {
        $requestData = $this->parser->parseRequest();

        $this->assertIsString($requestData['host']);
        $this->assertStringContainsString('/', $requestData['uri']);
        $this->assertSame('/?page=1', $requestData['uri']);
        $this->assertSame('GET', $requestData['method']);
        $this->assertIsArray($requestData['payload']);
        $this->assertSame(['page'=>1], $requestData['payload']);
        $this->assertIsString($requestData['ip']);
        $this->assertSame('127.0.0.1', $requestData['ip']);
        $this->assertIsString($requestData['token']);
    }

    /** @test  */
    public function response_parse_content_is_correct()
    {
        $responseData = $this->parser->parseResponse();

        $this->assertIsString($responseData['content']);
        $this->assertSame($this->response->content(), $responseData['content']);
    }

    /** @test */
    public function response_parse_is_correct()
    {
        $responseData = $this->parser->parseResponse();

        $this->assertIsInt($responseData['code']);
        $this->assertSame(200, $responseData['code']);
        $this->assertIsFloat($responseData['time']);
    }
}
