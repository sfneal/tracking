<?php

namespace Sfneal\Tracking\Tests\Feature\Builders;

use Sfneal\Queries\RandomModelAttributeQuery;
use Sfneal\Tracking\Models\TrackTraffic;

class TrackTrafficBuilderTest extends BuilderTestCase
{
    use WhereUserTests;

    /**
     * @var TrackTraffic
     */
    protected $modelClass = TrackTraffic::class;

    /** @test */
    public function whereRequestUri()
    {
        $request_uri = (new RandomModelAttributeQuery($this->modelClass, 'request_uri'))->execute();

        $model = $this->modelClass::query()->whereRequestUri($request_uri)->get();

        $this->assertContains($request_uri, $model->pluck('request_uri'));
    }

    /** @test */
    public function orWhereRequestUri()
    {
        $request_uris = $this->modelClass::query()
            ->distinct()
            ->get('request_uri')
            ->shuffle()
            ->take(3)
            ->pluck('request_uri');

        $query = $this->modelClass::query();
        $request_uris->each(function (string $request_uri) use ($query) {
            $query->orWhereRequestUri($request_uri);
        });

        $model = $query->get();

        $request_uris->each(function (string $request_uri) use ($model) {
            $this->assertContains($request_uri, $model->pluck('request_uri'));
        });
    }

    /** @test */
    public function whereRequestUriIn()
    {
        $expected = 4;

        $request_uris = $this->modelClass::query()
            ->distinct()
            ->get('request_uri')
            ->shuffle()
            ->take($expected)
            ->pluck('request_uri')
            ->toArray();

        $models = $this->modelClass::query()->whereRequestUriIn($request_uris)->get();

        foreach ($request_uris as $request_uri) {
            $this->assertContains($request_uri, $models->pluck('request_uri'));
        }
    }

    /** @test */
    public function whereEnvironment()
    {
        $app_environment = (new RandomModelAttributeQuery($this->modelClass, 'app_environment'))->execute();

        $models = $this->modelClass::query()->whereEnvironment($app_environment)->get();

        foreach ($models as $model) {
            $this->assertSame($app_environment, $model->app_environment);
        }
    }

    /** @test */
    public function whereEnvironmentProduction()
    {
        $app_environment = 'production';
        $models = $this->modelClass::query()->whereEnvironmentProduction()->get();

        foreach ($models as $model) {
            $this->assertSame($app_environment, $model->app_environment);
        }
    }

    /** @test */
    public function whereEnvironmentDevelopment()
    {
        $app_environment = 'development';
        $models = $this->modelClass::query()->whereEnvironmentDevelopment()->get();

        foreach ($models as $model) {
            $this->assertSame($app_environment, $model->app_environment);
        }
    }
}
