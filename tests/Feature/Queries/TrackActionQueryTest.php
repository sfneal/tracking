<?php

namespace Sfneal\Tracking\Tests\Feature\Queries;

use Sfneal\Queries\RandomModelAttributeQuery;
use Sfneal\Tracking\Builders\TrackActionBuilder;
use Sfneal\Tracking\Models\TrackAction;
use Sfneal\Tracking\Queries\TrackActionQuery;

class TrackActionQueryTest extends QueriesTestCase
{
    // todo: add methods to test 'period' key

    /**
     * @var TrackAction
     */
    public $modelClass = TrackAction::class;

    /** @test */
    public function query_without_params()
    {
        // Create a request
        $request = $this->createRequest();

        // `TrackAction` records
        $records = TrackAction::query()->get();

        // Query Builder
        $builder = (new TrackActionQuery($request))->execute();

        // Execute assertions
        $this->executeAssertions($records, $builder, TrackActionBuilder::class);
    }

    /** @test */
    public function query_with_table_param()
    {
        // Test each unique table name
        foreach (TrackAction::query()->distinct()->getFlatArray('model_table') as $table) {
            // `TrackAction` records for the $table
            $records = TrackAction::query()
                ->where('model_table', '=', $table)
                ->get();

            // Create a request
            $request = $this->createRequest([], [
                'table' => $table,
            ]);

            // Query Builder
            $builder = (new TrackActionQuery($request))->execute();

            // Execute assertions
            $this->executeAssertions($records, $builder, TrackActionBuilder::class);
        }
    }

    /** @test */
    public function query_with_key_param()
    {
        // Model Key
        $model_key = (new RandomModelAttributeQuery(TrackAction::class, 'model_key'))->execute();

        // `TrackAction` record for the $model_key
        $records = TrackAction::query()
            ->where('model_key', '=', $model_key)
            ->get();

        // Create a request
        $request = $this->createRequest([], [
            'key' => $model_key,
        ]);

        // Query Builder
        $builder = (new TrackActionQuery($request))->execute();

        // Execute assertions
        $this->executeAssertions($records, $builder, TrackActionBuilder::class);
    }

    /** @test */
    public function query_with_table_and_key_params()
    {
        // Test each unique table name
        foreach (TrackAction::query()->distinct()->getFlatArray('model_table') as $table) {
            // Model Key
            $model_key = (new RandomModelAttributeQuery(TrackAction::class, 'model_table'))->execute();

            // `TrackAction` records for the $table
            $records = TrackAction::query()
                ->where('model_table', '=', $table)
                ->where('model_key', '=', $model_key)
                ->get();

            // Create a request
            $request = $this->createRequest([], [
                'table' => $table,
                'key' => $model_key,
            ]);

            // Query Builder
            $builder = (new TrackActionQuery($request))->execute();

            // Execute assertions
            $this->executeAssertions($records, $builder, TrackActionBuilder::class);
        }
    }
}
