<?php

namespace Sfneal\Tracking\Tests\Feature\Queries;

use Sfneal\Tracking\Builders\TrackActionBuilder;
use Sfneal\Tracking\Models\TrackAction;
use Sfneal\Tracking\Queries\TrackActionQuery;
use Sfneal\Tracking\Tests\CreateRequest;

class TrackActionQueryTest extends QueriesTestCase
{
    use CreateRequest;

    /**
     * @var TrackAction
     */
    public $modelClass = TrackAction::class;

    /** @test */
    public function query_without_params()
    {
        // Create a request
        $request = $this->createRequest();

        // Query Builder
        $builder = (new TrackActionQuery($request))->execute();

        $this->assertInstanceOf(TrackActionBuilder::class, $builder);
        $this->assertEquals($this->count, $builder->count());
    }
}
