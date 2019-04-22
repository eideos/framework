<?php

namespace Eideos\Framework;

use App\AppModel;

class RoleRight extends AppModel {

    protected $table = 'roles_rights';

    protected $fillable = ['right_id', 'role_id'];

    public function role() {
        return $this->belongsTo('Eideos\Framework\Role');
    }

    public function right() {
        return $this->belongsToMany('Eideos\Framework\Right');
    }

}
