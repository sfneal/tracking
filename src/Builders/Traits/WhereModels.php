<?php

namespace Sfneal\Tracking\Builders\Traits;

use Sfneal\Helpers\Strings\StringHelpers;

trait WhereModels
{
    /**
     * Scope query to activity on a specific trackable id.
     *
     * @param  mixed  $trackable_id
     * @return $this
     */
    public function whereTrackableId($trackable_id): self
    {
        $trackable_id = (array) $trackable_id;
        $this->where(function (self $query) use ($trackable_id) {
            foreach ($trackable_id as $key) {
                $query->orWhere('trackable_id', '=', $key);
            }
        });

        return $this;
    }

    /**
     * Scope query to activity on a specific trackable type.
     *
     * @param  mixed  $trackable_type
     * @return $this
     */
    public function whereTrackableType($trackable_type): self
    {
        $trackable_type = (array) $trackable_type;
        $this->where(function (self $query) use ($trackable_type) {
            foreach ($trackable_type as $table) {
                if ((new StringHelpers($table))->inString('_')) {
                    $query->orWhereLike('trackable_type', $table);
                } else {
                    $query->orWhere('trackable_type', '=', $table);
                }
            }
        });

        return $this;
    }
}
