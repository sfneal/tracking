<?php

namespace Sfneal\Tracking\Builders\Traits;

use Sfneal\Helpers\Strings\StringHelpers;

trait WhereModels
{
    /**
     * Scope query to activity on a specific model key.
     *
     * @param mixed $model_key
     *
     * @return $this
     */
    public function whereModelKey($model_key): self
    {
        $model_key = (array) $model_key;
        $this->where(function (self $query) use ($model_key) {
            foreach ($model_key as $key) {
                $query->orWhere('model_key', '=', $key);
            }
        });

        return $this;
    }

    /**
     * Scope query to activity on a specific model key.
     *
     * @param mixed $model_table
     *
     * @return $this
     */
    public function whereModelTable($model_table): self
    {
        $model_table = (array) $model_table;
        $this->where(function (self $query) use ($model_table) {
            foreach ($model_table as $table) {
                if ((new StringHelpers($table))->inString('_')) {
                    $query->orWhereLike('model_table', $table);
                } else {
                    $query->orWhere('model_table', '=', $table);
                }
            }
        });

        return $this;
    }
}
