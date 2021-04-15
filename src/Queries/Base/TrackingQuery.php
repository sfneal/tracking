<?php

namespace Sfneal\Tracking\Queries\Base;

use Illuminate\Http\Request;
use Sfneal\Queries\Query;

abstract class TrackingQuery extends Query
{
    // todo: improve constructor arguments

    /**
     * @var Request|null
     */
    protected $request;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var array|null
     */
    protected $relationships;

    /**
     * TrackActionQuery constructor.
     * @param Request|null $request
     * @param array|null   $parameters
     * @param array|null   $relationships
     */
    public function __construct(Request $request = null, array $parameters = null, array $relationships = null)
    {
        $this->request = $request;
        $this->parameters = $parameters ?? [];
        $this->relationships = $relationships;
    }
}
