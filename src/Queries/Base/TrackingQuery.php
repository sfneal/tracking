<?php

namespace Sfneal\Tracking\Queries\Base;

use Sfneal\Queries\Query;
use Sfneal\Queries\Traits\HasRelationships;
use Sfneal\Tracking\Requests\TrackRequest;

abstract class TrackingQuery extends Query
{
    use HasRelationships;

    /**
     * @var TrackRequest|null
     */
    protected $request;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * TrackActionQuery constructor.
     * @param TrackRequest|null $request
     * @param array|null   $parameters
     */
    public function __construct(TrackRequest $request = null, array $parameters = null)
    {
        $this->request = $request;
        $this->parameters = $parameters ?? [];

        // Merge validated request inputs with parameters
        if ($validated = $this->request->validated()) {
            $this->parameters = array_merge($this->parameters, $validated);
        }
    }
}
