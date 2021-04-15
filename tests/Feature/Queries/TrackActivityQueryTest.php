<?php

namespace Sfneal\Tracking\Tests\Feature\Queries;

use Sfneal\Tracking\Builders\TrackActivityBuilder;
use Sfneal\Tracking\Models\TrackActivity;
use Sfneal\Tracking\Queries\TrackActivityQuery;

class TrackActivityQueryTest extends QueriesTestCase
{
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
        $model_key = TrackActivity::query()
            ->get('model_key')
            ->shuffle()
            ->first()
            ->model_key;

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
            $model_key = TrackActivity::query()
                ->where('model_table', '=', $table)
                ->get('model_key')
                ->shuffle()
                ->first()
                ->model_key;

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
}
