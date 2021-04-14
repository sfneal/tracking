<?php

namespace Sfneal\Tracking\Queries;

use Illuminate\Database\Eloquent\Builder;
use Sfneal\Helpers\Time\TimePeriods;
use Sfneal\Queries\Traits\ParamGetter;
use Sfneal\Tracking\Builders\TrackActivityBuilder;
use Sfneal\Tracking\Models\TrackActivity;
use Sfneal\Tracking\Queries\Base\TrackingQuery;

class TrackActivityQuery extends TrackingQuery
{
    // todo: add request validation

    use ParamGetter;

    /**
     * Relationships that should be eager loaded by default.
     */
    private const DEFAULT_RELATIONSHIPS = [
        'user',
        'tracking',
        'plan',
        'planManagement',
        'planManagement.plan',
        'project',
        'task',
        'task.project',
        'taskRecord',
        'taskRecord.task',
        'taskRecord.task.project',
    ];

    /**
     * Retrieve a Query builder.
     *
     * @return TrackActivityBuilder|Builder
     */
    protected function builder(): TrackActivityBuilder
    {
        return TrackActivity::query()
            ->with($this->relationships ?? self::DEFAULT_RELATIONSHIPS);
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
            $tracking->whereModelTable($table);
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
