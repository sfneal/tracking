<?php

namespace Sfneal\Tracking\Tests\Feature\Queries;

use Sfneal\Queries\RandomModelAttributeQuery;
use Sfneal\Tracking\Builders\TrackActivityBuilder;
use Sfneal\Tracking\Models\TrackActivity;
use Sfneal\Tracking\Queries\TrackActivityQuery;

class TrackActivityQueryTest extends QueriesTestCase
{
    // todo: add methods to test 'period' key

    /**
     * @var TrackActivity
     */
    public $modelClass = TrackActivity::class;

    /** @test */
    public function query_without_params()
    {
        // Create a request
        $request = $this->createRequest();

        // Query Builder
        $builder = (new TrackActivityQuery($request))->execute();

        // Execute assertions
        $this->assertInstanceOf(TrackActivityBuilder::class, $builder);
        $this->assertEquals($this->count, $builder->count());
    }

    /** @test */
    public function query_with_table_param()
    {
        // Test each unique table name
        foreach (TrackActivity::query()->distinct()->getFlatArray('model_table') as $table) {
            // `TrackAction` records for the $table
            $records = TrackActivity::query()
                ->where('model_table', '=', $table)
                ->get();

            // Create a request
            $request = $this->createRequest([], [
                'table' => $table,
            ]);

            // Query Builder
            $builder = (new TrackActivityQuery($request))->execute();

            // Execute assertions
            $this->assertInstanceOf(TrackActivityBuilder::class, $builder);
            $this->assertEquals($records->count(), $builder->count());
            $this->assertEquals($records, $builder->get());
        }
    }

    /** @test */
    public function query_with_user_param()
    {
        // Test each unique table name
        foreach (TrackActivity::query()->distinct()->limit(20)->getFlatArray('user_id') as $user_id) {
            // `TrackAction` records for the $table
            $records = TrackActivity::query()
                ->where('user_id', '=', $user_id)
                ->get();

            // Create a request
            $request = $this->createRequest([], [
                'user' => $user_id,
            ]);

            // Query Builder
            $builder = (new TrackActivityQuery($request))->execute();

            // Execute assertions
            $this->assertInstanceOf(TrackActivityBuilder::class, $builder);
            $this->assertEquals($records->count(), $builder->count());
            $this->assertEquals($records, $builder->get());
        }
    }

    /** @test */
    public function query_with_users_param()
    {
        // Test each unique table name
        $user_ids = TrackActivity::query()->distinct()->limit(20)->getFlatArray('user_id');

        // `TrackAction` records for the $table
        $records = TrackActivity::query()
            ->whereIn('user_id', $user_ids)
            ->get();

        // Create a request
        $request = $this->createRequest([], [
            'users' => $user_ids,
        ]);

        // Query Builder
        $builder = (new TrackActivityQuery($request))->execute();

        // Execute assertions
        $this->assertInstanceOf(TrackActivityBuilder::class, $builder);
        $this->assertEquals($records->count(), $builder->count());
        $this->assertEquals($records, $builder->get());
    }

    /** @test */
    public function query_with_key_param()
    {
        // Model Key
        $model_key = (new RandomModelAttributeQuery(TrackActivity::class, 'model_key'))->execute();

        // `TrackAction` record for the $model_key
        $records = TrackActivity::query()
            ->where('model_key', '=', $model_key)
            ->get();

        // Create a request
        $request = $this->createRequest([], [
            'key' => $model_key,
        ]);

        // Query Builder
        $builder = (new TrackActivityQuery($request))->execute();

        // Execute assertions
        $this->assertInstanceOf(TrackActivityBuilder::class, $builder);
        $this->assertEquals($records->count(), $builder->count());
        $this->assertEquals($records, $builder->get());
    }

    /** @test */
    public function query_with_table_and_key_params()
    {
        // Test each unique table name
        foreach (TrackActivity::query()->distinct()->getFlatArray('model_table') as $table) {
            // Model Key
            $model_key = (new RandomModelAttributeQuery(TrackActivity::class, 'model_table'))->execute();

            // `TrackAction` records for the $table
            $records = TrackActivity::query()
                ->where('model_table', '=', $table)
                ->where('model_key', '=', $model_key)
                ->get();

            // Create a request
            $request = $this->createRequest([], [
                'table' => $table,
                'key' => $model_key,
            ]);

            // Query Builder
            $builder = (new TrackActivityQuery($request))->execute();

            // Execute assertions
            $this->assertInstanceOf(TrackActivityBuilder::class, $builder);
            $this->assertEquals($records->count(), $builder->count());
            $this->assertEquals($records, $builder->get());
        }
    }

    /** @test */
    public function query_with_period_param()
    {
        // Model Key
        $created_at_1 = (new RandomModelAttributeQuery(TrackActivity::class, 'created_at'))->execute();
        $created_at_2 = (new RandomModelAttributeQuery(TrackActivity::class, 'created_at'))->execute();
        $min = min($created_at_1, $created_at_2);
        $max = max($created_at_1, $created_at_2);

        // `TrackAction` record for the $model_key
        $records = TrackActivity::query()
            ->where('created_at', '>=', $min)
            ->where('created_at', '<=', $max)
            ->get();

        // Create a request
        $request = $this->createRequest([], [
            'period' => [
                $min,
                $max
            ],
        ]);

        // Query Builder
        $builder = (new TrackActivityQuery($request))->execute();

        // Execute assertions
        $this->assertInstanceOf(TrackActivityBuilder::class, $builder);
        $this->assertEquals($records->count(), $builder->count());
        $this->assertEquals($records, $builder->get());
    }
}
