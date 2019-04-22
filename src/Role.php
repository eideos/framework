<?php

namespace Eideos\Framework;

use App\AppModel;

class Role extends AppModel {

    protected $fillable = ['created_by', 'updated_by', 'name', 'description'];

    protected $dependentRelations = ['roles_users'];

    public function users() {
        return $this->belongsToMany('Eideos\Framework\User', 'roles_users', 'role_id');
    }

    public function rights() {
        return $this->belongsToMany('Eideos\Framework\Right', 'roles_rights', 'role_id');
    }

    public function roles_rights() {
        return $this->hasMany('Eideos\Framework\RoleRight');
    }

    public function roles_users() {
        return $this->hasMany('Eideos\Framework\RoleUser');
    }

    public static function boot() {
        static::deleting(function($role) {
            $role->roles_rights()->delete();
        });
        parent::boot();
    }

}
