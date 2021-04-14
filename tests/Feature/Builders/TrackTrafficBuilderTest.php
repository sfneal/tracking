<?php

namespace Sfneal\Tracking\Tests\Feature\Builders;

use Sfneal\Tracking\Models\TrackTraffic;
use Sfneal\Tracking\Tests\Feature\Builders\Traits\WhereUserTests;

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
        $expected = 1;

        $request_uri = $this->modelClass::query()
            ->distinct()
            ->get('request_uri')
            ->shuffle()
            ->take($expected)
            ->pluck('request_uri')
            ->first();

        $model = $this->modelClass::query()->whereRequestUri($request_uri)->get();

        $this->assertContains($request_uri, $model->pluck('request_uri'));
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
        $expected = 1;

        $app_environment = $this->modelClass::query()
            ->distinct()
            ->get('app_environment')
            ->shuffle()
            ->take($expected)
            ->pluck('app_environment')
            ->first();

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
