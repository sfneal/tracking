<?php

namespace Sfneal\Tracking\Queries;

use Illuminate\Http\Request;
use Sfneal\Helpers\Time\TimePeriods;
use Sfneal\Queries\AbstractQueryStatic;
use Sfneal\Queries\Traits\ParamGetter;
use Sfneal\Tracking\Builders\TrackActivityBuilder;
use Sfneal\Tracking\Models\TrackActivity;

// todo: refactor
class TrackActivityQuery extends AbstractQueryStatic
{
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
     * Retrieve a TrackActivity by table query result set.
     *
     * @param Request|null $request
     * @param array        $parameters
     * @param array|null   $relationships
     *
     * @return TrackActivityBuilder
     */
    public static function execute(Request $request = null, array $parameters = [], array $relationships = null): TrackActivityBuilder
    {
        $tracking = TrackActivity::query()
            ->with($relationships ?? self::DEFAULT_RELATIONSHIPS);

        // Table
        if ($table = self::getParam($request, $parameters, 'table')) {
            $tracking->whereModelTable($table);
        }

        // User
        if ($user = self::getParam($request, $parameters, 'user')) {
            $tracking->whereUser($user);
        }

        // User(s)
        if ($users = self::getParam($request, $parameters, 'users')) {
            $tracking->whereUserIn($users);
        }

        // Key
        if ($model_keys = self::getParam($request, $parameters, 'key')) {
            $tracking->whereModelKey($model_keys);
        }

        // Time Period
        if ($period = self::getParam($request, $parameters, 'period')) {
            if (is_string($period)) {
                $period = TimePeriods::timePeriod($period);
            }
            $tracking->whereBetween('created_at', $period);
        }

        return $tracking;
    }
}
