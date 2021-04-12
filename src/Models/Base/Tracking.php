<?php

namespace Sfneal\Tracking\Models\Base;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sfneal\Models\Model;
use Sfneal\Scopes\CreatedOrderScope;
use Sfneal\Users\Models\User;

abstract class Tracking extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new CreatedOrderScope());
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'updated_at', 'created_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'model_changes'   => 'array',
        'request_payload' => 'array',
    ];

    protected $appends = [
        'has_model_changes',
    ];

    /**
     * User relationship.
     *
     * @return BelongsTo|User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Mutate date into human readable format.
     *
     * @return false|string
     */
    public function getDateAttribute()
    {
        return date('Y-m-d', strtotime($this->created_at));
    }

    /**
     * Mutate time into human readable format.
     *
     * @return false|string
     */
    public function getTimeAttribute()
    {
        return date('h:i a', strtotime($this->created_at));
    }

    /**
     * Mutate model changes array to remove any dates attributes before display.
     *
     * @param $value
     *
     * @return array
     */
    public function getModelChangesAttribute($value)
    {
        // Remove $dates from returned array
        if (isset($value) && ! empty($value)) {
            return array_filter(json_decode($value, true), function ($val) {
                return ! in_array($val, $this->dates);
            }, ARRAY_FILTER_USE_KEY);
        } else {
            return [];
        }
    }

    /**
     * Determine if an activity or action instance has model_changes.
     *
     * @return bool
     */
    public function getHasModelChangesAttribute()
    {
        return count($this->model_changes) > 0;
    }
}
