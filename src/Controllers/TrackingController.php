<?php

namespace Sfneal\Tracking\Controllers;

use Domain\Users\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Sfneal\Controllers\AbstractController;
use Sfneal\Helpers\Time\TimePeriods;
use Sfneal\Tracking\Queries\TrackActionQuery;
use Sfneal\Tracking\Queries\TrackActivityQuery;

class TrackingController extends AbstractController
{
    // todo: add to config
    /**
     * Routes & views prefix.
     */
    private const PREFIX = 'support.tracking';

    /**
     * Tables with viewable activity.
     */
    private const TABLES = ['plan', 'project', 'task'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the Activity Tracking dashboard.
     *
     * @param Request $request
     * @return array|Factory|View|mixed
     */
    public function index(Request $request)
    {
        // todo: add 'users' to config
        return view(self::PREFIX.'.index', [
            'title' => 'Activity Tracking',
            'tables' => self::TABLES,
            'users' => User::all(),
            'times' => TimePeriods::get('today', 'yesterday', 'thisWeek', 'thisMonth'),
        ]);
    }

    /**
     * Display a table of activity in particular tables.
     *
     * @param Request $request
     * @return array|Factory|View|mixed
     */
    public function show(Request $request)
    {
        return view(self::PREFIX.'.show', [
            'title' => ucwords($request->input('title')),
        ]);
    }

    /**
     * Display table of activity history for all Plans.
     *
     * @param Request $request
     * @return array|Factory|View|mixed
     */
    public function activity(Request $request)
    {
        return view(self::PREFIX.'.activity.results', [
            // Retrieve Collection of Activities
            'activities' => TrackActivityQuery::execute($request)->get(),

            // Don't show plan_ids if a model_key has been specified
            'hide_id' => $request->has('key'),

            // Don't show user ID's if a user_id has been specified
            'hide_user' => $request->has('user') || $request->has('users'),
        ]);
    }

    /**
     * Display table of action history for all Plans.
     *
     * @param Request $request
     * @return array|Factory|View|mixed
     */
    public function action(Request $request)
    {
        return view(self::PREFIX.'.actions.results', [
            // Retrieve Collection of Actions
            'actions' => TrackActionQuery::execute($request)->get(),

            // Don't show plan_ids if a model_key has been specified
            'hide_id' => $request->has('key'),
        ]);
    }
}
