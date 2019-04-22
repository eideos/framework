<?php

namespace Eideos\Framework;

use App\AppModel;

class Audit extends AppModel {

    public function user() {
        return $this->belongsTo('Eideos\Framework\User', 'user_id');
    }

}
