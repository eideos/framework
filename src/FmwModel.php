<?php

namespace Eideos\Framework;

use Illuminate\Database\Eloquent\Model;

class FmwModel extends Model {

    public static function boot() {
        static::saving(function ($model) {
            foreach (array_keys($model->getAttributes()) as $key) {
                if (!\Schema::connection($model->getConnectionName())->hasColumn($model->getTable(), $key)) {
                    unset($model->$key);
                }
            }
        });
        parent::boot();
    }

}
