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

        // Execute assertions
        $this->assertInstanceOf(TrackActionBuilder::class, $builder);
        $this->assertEquals($this->count, $builder->count());
    }

    /** @test */
    public function query_with_table_param()
    {
        // Table name
        $table = 'people';

        // All of `TrackAction` records
        $records = TrackAction::query()
            ->where('model_table', '=', $table)
            ->get();

        // Create a request
        $request = $this->createRequest([], [
            'table' => $table
        ]);

        // Query Builder
        $builder = (new TrackActionQuery($request))->execute();

        // Execute assertions
        $this->assertInstanceOf(TrackActionBuilder::class, $builder);
        $this->assertEquals($records->count(), $builder->count());
        $this->assertEquals($records, $builder->get());
    }
}
