<?php

namespace Eideos\Framework;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    
    use Notifiable;
    use HasApiTokens;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_by',
        'updated_by',
        'firstname',
        'lastname',
        'email',
        'password',
        'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public $appends = ['fullname', 'tmp_roles'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (function_exists('get_custom_model_properties')) {
            $attributes = get_custom_model_properties(get_class($this));
            if (!empty($attributes)) {
                foreach ($attributes as $attribute => $value) {
                    $this->{$attribute} = $value;
                }
            }
        }
    }

    public function getTmpRolesAttribute()
    {
        return $this->roles->pluck('name')->implode(", ");
    }

    public function getFullnameAttribute()
    {
        return ($this->firstname ?? "") . " " . ($this->lastname ?? "");
    }

    public function transformFullnameAttribute()
    {
        return "CONCAT(firstname, ' ', lastname)";
    }

    public function blocks()
    {
        return $this->hasMany('Eideos\Framework\Block', 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany('Eideos\Framework\Role', 'roles_users', 'user_id');
    }
}
