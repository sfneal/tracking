<?php

namespace Sfneal\Tracking\Queries\Base;

use Illuminate\Http\Request;
use Sfneal\Queries\Query;
use Sfneal\Queries\Traits\HasRelationships;

abstract class TrackingQuery extends Query
{
    use HasRelationships;

    /**
     * @var Request|null
     */
    protected $request;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * TrackActionQuery constructor.
     * @param Request|null $request
     * @param array|null   $parameters
     */
    public function __construct(Request $request = null, array $parameters = null)
    {
        $this->request = $request;
        $this->parameters = $parameters ?? [];
    }
}
