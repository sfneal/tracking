<?php

namespace Sfneal\Tracking\Models;

use Database\Factories\TrackActivityFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Sfneal\Scopes\CreatedOrderScope;
use Sfneal\Scopes\IdOrderScope;
use Sfneal\Tracking\Builders\TrackActivityBuilder;
use Sfneal\Tracking\Models\Base\Tracking;
use Sfneal\Tracking\Models\Traits\TrackingRelationships;
use Sfneal\Tracking\Utils\ModelAdapter;

class TrackActivity extends Tracking
{
    // todo: add use of polymorphic relationships
    use HasFactory;
    use TrackingRelationships;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new CreatedOrderScope());
        static::addGlobalScope(new IdOrderScope());
    }

    protected $table = 'track_activity';
    protected $primaryKey = 'track_activity_id';

    protected $fillable = [
        'track_activity_id',
        'user_id',
        'route',
        'description',
        'model_table',
        'model_key',
        'model_changes',
        'request_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'int',
        'model_key' => 'int',
        'model_changes' => 'array',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return TrackActivityFactory
     */
    protected static function newFactory(): TrackActivityFactory
    {
        return new TrackActivityFactory();
    }

    /**
     * Query Builder.
     *
     * @param $query
     *
     * @return TrackActivityBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new TrackActivityBuilder($query);
    }

    /**
     * @return TrackActivityBuilder|Builder
     */
    public static function query(): TrackActivityBuilder
    {
        return parent::query();
    }

    /**
     * Related TrackTraffic data.
     *
     * // todo: add tests
     *
     * @return BelongsTo
     */
    public function tracking()
    {
        return $this->belongsTo(ModelAdapter::TrackTraffic(), 'request_token', 'request_token')
            ->withoutGlobalScope(SoftDeletingScope::class);
    }

    /**
     * Determine if the Activity has model changes or a request payload.
     *
     * @return bool
     */
    public function getHasModelChangesAttribute()
    {
        return parent::getHasModelChangesAttribute() || $this->hasTrackingLoadedWithPayload();
    }

    /**
     * Determine if the 'tracking' relationship has been eager loaded and that it has a request_payload.
     *
     * @return bool
     */
    public function hasTrackingLoadedWithPayload()
    {
        return $this->relationLoaded('tracking') && isset($this->tracking->request_payload);
    }
}
