<?php

namespace Eideos\Framework;

use App\AppModel;

class Audit extends AppModel
{

    protected $fillable = [
        'created_by',
        'updated_by',
        'user_type',
        'user_id',
        'auditable_type',
        'auditable_id',
        'event'
    ];

    public function user()
    {
        return $this->belongsTo('Eideos\Framework\User', 'user_id');
    }
}
