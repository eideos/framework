<?php

namespace Eideos\Framework;

use App\AppModel;

class Right extends AppModel {

    protected $fillable = ['created_by', 'updated_by', 'name', 'description'];

    public function permissions() {
        return $this->hasMany('Eideos\Framework\Permission');
    }

    public function roles() {
        return $this->belongsToMany('Eideos\Framework\Role', 'roles_rights', 'right_id');
    }

    public function roles_rights() {
        return $this->hasMany('Eideos\Framework\RoleRight');
    }

    public static function boot() {
        static::deleting(function($right) {
            $right->permissions()->delete();
            $right->roles_rights()->delete();
        });
        parent::boot();
    }

}
