<?php

namespace Sfneal\Tracking\Tests\Feature\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Sfneal\Testing\Utils\Interfaces\RequestCreator;
use Sfneal\Tracking\Models\Base\Tracking;
use Sfneal\Tracking\Requests\TrackRequest;
use Sfneal\Tracking\Tests\TestCase;

class QueriesTestCase extends TestCase implements RequestCreator
{
    /**
     * @var Tracking
     */
    public $modelClass = Tracking::class;

    /**
     * @var Collection
     */
    public $models;

    /**
     * @var int
     */
    public $count = 1000;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // Retrieve the People model from an Address model
        $this->models = $this->modelClass::factory()->count($this->count)->create();
    }

    /**
     * Create a Request to be used in test methods.
     *
     * @param  array  $headers
     * @param  array  $parameters
     * @param  array  $cookies
     * @param  array  $files
     * @param  array  $server
     * @param  null  $content
     * @return TrackRequest
     */
    public function createRequest(array $headers = [],
                                     array $parameters = [],
                                     array $cookies = [],
                                     array $files = [],
                                     array $server = [],
                                     $content = null): TrackRequest
    {
        $request = TrackRequest::create('/', 'GET', $parameters, $cookies, $files, $server, $content);

        foreach ($headers as $header => $value) {
            $request->headers->set($header, $value);
        }

        return $request;
    }

    /**
     * Execute Query test assertions.
     *
     * @param  Collection  $records
     * @param  Builder  $builder
     * @param  string  $queryBuilder
     */
    protected function executeAssertions(Collection $records, Builder $builder, string $queryBuilder)
    {
        $this->assertInstanceOf($queryBuilder, $builder);
        $this->assertEquals($records->count(), $builder->count());
        $this->assertEquals($records, $builder->get());
    }
}
