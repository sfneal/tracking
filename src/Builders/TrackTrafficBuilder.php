<?php

namespace Sfneal\Tracking\Builders;

use Sfneal\Builders\QueryBuilder;
use Sfneal\Users\Builders\Interfaces\WhereUserInterface;
use Sfneal\Users\Builders\Traits\WhereUser;

class TrackTrafficBuilder extends QueryBuilder implements WhereUserInterface
{
    use WhereUser;

    /**
     * Scope query results to Traffic sent to a particular endpoint $uri.
     *
     * @param  string  $uri
     * @param  string  $operator
     * @param  string  $boolean
     * @return $this
     */
    public function whereRequestUri(string $uri, string $operator = '=', string $boolean = 'and'): self
    {
        $this->where('request_uri', $operator, $uri, $boolean);

        return $this;
    }

    /**
     * Add an 'or where' request_uri clause to the query.
     *
     * @param  string  $uri
     * @param  string  $operator
     * @return $this
     */
    public function orWhereRequestUri(string $uri, string $operator = '='): self
    {
        $this->whereRequestUri($uri, $operator, 'or');

        return $this;
    }

    /**
     * Scope query results to Traffic sent to an array of $uris.
     *
     * @param  array  $uris
     * @param  string  $boolean
     * @param  bool  $not
     * @return $this
     */
    public function whereRequestUriIn(array $uris, string $boolean = 'and', bool $not = false): self
    {
        $this->whereIn('request_uri', $uris, $boolean, $not);

        return $this;
    }

    /**
     * Add a where clause that scopes query results to Traffic originating in a particular app environment.
     *
     * @param  string  $environment
     * @param  string  $operator
     * @param  string  $boolean
     * @return $this
     */
    public function whereEnvironment(string $environment, string $operator = '=', string $boolean = 'and'): self
    {
        $this->where('app_environment', $operator, $environment, $boolean);

        return $this;
    }

    /**
     * Scope query results to only Traffic originating from a 'production' environment.
     *
     * @return $this
     */
    public function whereEnvironmentProduction(): self
    {
        $this->whereEnvironment('production');

        return $this;
    }

    /**
     * Scope query results to only Traffic originating from a 'development' environment.
     *
     * @return $this
     */
    public function whereEnvironmentDevelopment(): self
    {
        $this->whereEnvironment('development');

        return $this;
    }
}
