<?php

namespace Eideos\Framework;

use App\AppModel;

class RoleUser extends AppModel {

    protected $table = 'roles_users';

    protected $fillable = ['role_id', 'user_id'];

    public function user() {
        return $this->belongsTo('Eideos\Framework\User');
    }

    public function role() {
        return $this->belongsTo('Eideos\Framework\Role');
    }
}
