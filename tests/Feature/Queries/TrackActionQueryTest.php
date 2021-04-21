<?php

namespace Sfneal\Tracking\Tests\Feature\Queries;

use Sfneal\Queries\RandomModelAttributeQuery;
use Sfneal\Tracking\Builders\TrackActionBuilder;
use Sfneal\Tracking\Models\TrackAction;
use Sfneal\Tracking\Queries\TrackActionQuery;

class TrackActionQueryTest extends QueriesTestCase
{
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
        TrackAction::query()
            ->distinct()
            ->pluck('model_table')
            ->values()
            ->each(function (string $table) {
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
            });
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
        TrackAction::query()
            ->distinct()
            ->pluck('model_table')
            ->values()
            ->each(function (string $table) {
                // Model Key
                $model_key = TrackAction::query()
                    ->whereModelTable($table)
                    ->get('model_key')
                    ->shuffle()
                    ->take(1)
                    ->pluck('model_key')
                    ->first();

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
            });
    }

    /** @test */
    public function query_with_period_param()
    {
        // Model Key
        $created_at_1 = (new RandomModelAttributeQuery(TrackAction::class, 'created_at'))->execute();
        $created_at_2 = (new RandomModelAttributeQuery(TrackAction::class, 'created_at'))->execute();
        $min = min($created_at_1, $created_at_2);
        $max = max($created_at_1, $created_at_2);

        // `TrackAction` record for the $model_key
        $records = TrackAction::query()
            ->whereBetween('created_at', [$min, $max])
            ->get();

        // Create a request
        $request = $this->createRequest([], [
            'period' => [
                $min,
                $max,
            ],
        ]);

        // Query Builder
        $builder = (new TrackActionQuery($request))->execute();

        // Execute assertions
        $this->executeAssertions($records, $builder, TrackActionBuilder::class);
    }
}
