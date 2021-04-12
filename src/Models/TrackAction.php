<?php

namespace Sfneal\Tracking\Models;

use Illuminate\Database\Eloquent\Builder;
use Sfneal\Scopes\CreatedOrderScope;
use Sfneal\Scopes\IdOrderScope;
use Sfneal\Tracking\Builders\TrackActionBuilder;
use Sfneal\Tracking\Models\Base\Tracking;
use Sfneal\Tracking\Models\Traits\TrackingRelationships;

class TrackAction extends Tracking
{
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

    protected $table = 'track_action';
    protected $primaryKey = 'track_action_id';

    protected $fillable = [
        'track_action_id',
        'action',
        'model_table',
        'model_key',
        'model_changes',
    ];

    /**
     * Query Builder.
     *
     * @param $query
     *
     * @return TrackActionBuilder()
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
}
