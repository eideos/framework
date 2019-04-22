<?php

namespace Eideos\Framework;

use App\AppModel;

class Permission extends AppModel {

    protected $fillable = [
        'created_by',
        'updated_by',
        'right_id',
        'controller',
        'action'
    ];

    public function right() {
        return $this->belongsTo('Eideos\Framework\Right');
    }

}
