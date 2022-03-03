<?php

namespace Sfneal\Tracking\Models;

use Database\Factories\TrackActionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Sfneal\Scopes\CreatedOrderScope;
use Sfneal\Scopes\IdOrderScope;
use Sfneal\Tracking\Builders\TrackActionBuilder;
use Sfneal\Tracking\Models\Base\Tracking;

class TrackAction extends Tracking
{
    use HasFactory;

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

    protected $table = 'track_action';
    protected $primaryKey = 'track_action_id';

    protected $fillable = [
        'track_action_id',
        'action',
        'model_changes',
        'trackable_id',
        'trackable_type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'model_changes' => 'array',
        'trackable_id' => 'int',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return TrackActionFactory
     */
    protected static function newFactory(): TrackActionFactory
    {
        return new TrackActionFactory();
    }

    /**
     * Query Builder.
     *
     * @param $query
     * @return TrackActionBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new TrackActionBuilder($query);
    }

    /**
     * @return TrackActionBuilder|Builder
     */
    public static function query(): TrackActionBuilder
    {
        return parent::query();
    }

    /**
     * Get the owning trackable model.
     *
     * @return MorphTo
     */
    public function trackable(): MorphTo
    {
        return $this->morphTo();
    }
}
