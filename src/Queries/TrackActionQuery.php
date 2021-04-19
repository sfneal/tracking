<?php

namespace Sfneal\Tracking\Queries;

use Sfneal\Helpers\Time\TimePeriods;
use Sfneal\Queries\Traits\ParamGetter;
use Sfneal\Tracking\Builders\TrackActionBuilder;
use Sfneal\Tracking\Queries\Base\TrackingQuery;
use Sfneal\Tracking\Utils\ModelAdapter;

class TrackActionQuery extends TrackingQuery
{
    // todo: add request validation

    use ParamGetter;

    /**
     * Retrieve a Query builder.
     *
     * @return TrackActionBuilder
     */
    protected function builder(): TrackActionBuilder
    {
        $builder = ModelAdapter::TrackAction()::query();

        if (! empty($this->relationships)) {
            $builder->with($this->relationships);
        }

        return $builder;
    }

    /**
     * Retrieve a TrackActivity by table query result set.
     *
     * @return TrackActionBuilder
     */
    public function execute(): TrackActionBuilder
    {
        $tracking = $this->builder();

        // Table
        if ($table = self::getParam($this->request, $this->parameters, 'table')) {
            $tracking->whereModelTable($table);
        }

        // Key
        if ($model_keys = self::getParam($this->request, $this->parameters, 'key')) {
            $tracking->whereModelKey($model_keys);
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
