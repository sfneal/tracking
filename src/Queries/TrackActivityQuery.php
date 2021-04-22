<?php

namespace Sfneal\Tracking\Queries;

use Sfneal\Helpers\Time\TimePeriods;
use Sfneal\Queries\Traits\ParamGetter;
use Sfneal\Tracking\Builders\TrackActivityBuilder;
use Sfneal\Tracking\Queries\Base\TrackingQuery;
use Sfneal\Tracking\Utils\ModelAdapter;

class TrackActivityQuery extends TrackingQuery
{
    // todo: refactor params?

    use ParamGetter;

    /**
     * Retrieve a Query builder.
     *
     * @return TrackActivityBuilder
     */
    protected function builder(): TrackActivityBuilder
    {
        $builder = ModelAdapter::TrackActivity()::query();

        if (! empty($this->relationships)) {
            $builder->with($this->relationships);
        }

        return $builder;
    }

    /**
     * Retrieve a TrackActivity by table query result set.
     *
     * @return TrackActivityBuilder
     */
    public function execute(): TrackActivityBuilder
    {
        $tracking = $this->builder();

        // Table
        if ($table = self::getParam($this->request, $this->parameters, 'table')) {
            $tracking->whereTrackableType($table);
        }

        // User
        if ($user = self::getParam($this->request, $this->parameters, 'user')) {
            $tracking->whereUser($user);
        }

        // User(s)
        if ($users = self::getParam($this->request, $this->parameters, 'users')) {
            $tracking->whereUserIn($users);
        }

        // Key
        if ($trackable_ids = self::getParam($this->request, $this->parameters, 'key')) {
            $tracking->whereTrackableId($trackable_ids);
        }

        // Time Period
        if ($period = self::getParam($this->request, $this->parameters, 'period')) {
            if (is_string($period)) {
                $period = TimePeriods::timePeriod($period);
            }
            $tracking->whereBetween('created_at', $period);
        }

        return $tracking;
    }
}
