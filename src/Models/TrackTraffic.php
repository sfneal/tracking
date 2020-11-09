<?php

namespace Sfneal\Tracking\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sfneal\Tracking\Builders\TrackTrafficBuilder;
use Sfneal\Tracking\Models\Base\AbstractTracking;

class TrackTraffic extends AbstractTracking
{
    protected $table = 'track_traffic';
    protected $primaryKey = 'track_traffic_id';

    protected $fillable = [
        'track_traffic_id',
        'user_id',
        'session_id',
        'app_version',
        'app_environment',
        'request_host',
        'request_uri',
        'request_method',
        'request_payload',
        'request_browser',
        'request_ip',
        'request_referrer',
        'request_token',
        'response_code',
        'response_time',
        'response_content',
        'agent_platform',
        'agent_device',
        'agent_browser',
        'time_stamp',
    ];

    /**
     * Query Builder.
     *
     * @param $query
     *
     * @return TrackTrafficBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new TrackTrafficBuilder($query);
    }

    /**
     * @return TrackTrafficBuilder|Builder
     */
    public static function query(): TrackTrafficBuilder
    {
        return parent::query();
    }

    /**
     * Tracked activity that is associated with this traffic record.
     *
     * @return BelongsTo
     */
    public function activity()
    {
        return $this->belongsTo(TrackActivity::class, 'request_token', 'request_token');
    }

    /**
     * Set the `app_environment` attribute.
     *
     * @param null $value
     */
    public function setAppEnvironmentAttribute($value = null)
    {
        $this->attributes['app_environment'] = (isset($value) ? $value : env('APP_ENV'));
    }
}
