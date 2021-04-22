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
            ->pluck('trackable_type')
            ->values()
            ->each(function (string $table) {
                // `TrackAction` records for the $table
                $records = TrackAction::query()
                    ->whereTrackableType($table)
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
        $trackable_id = (new RandomModelAttributeQuery(TrackAction::class, 'trackable_id'))->execute();

        // `TrackAction` record for the $trackable_id
        $records = TrackAction::query()
            ->whereTrackableId($trackable_id)
            ->get();

        // Create a request
        $request = $this->createRequest([], [
            'key' => $trackable_id,
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
            ->pluck('trackable_type')
            ->values()
            ->each(function (string $table) {
                // Model Key
                $trackable_id = TrackAction::query()
                    ->whereTrackableType($table)
                    ->get('trackable_id')
                    ->shuffle()
                    ->take(1)
                    ->pluck('trackable_id')
                    ->first();

                // `TrackAction` records for the $table
                $records = TrackAction::query()
                    ->whereTrackableType($table)
                    ->whereTrackableId($trackable_id)
                    ->get();

                // Create a request
                $request = $this->createRequest([], [
                    'table' => $table,
                    'key' => $trackable_id,
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

        // `TrackAction` record for the $trackable_id
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
