<?php

namespace Eideos\Framework;

use App\AppModel;

class Button extends AppModel {

    protected $fillable = ['created_by', 'updated_by',
        'name', 'controller', 'action', 'icon', 'order', 'query',
        'refresh', 'color', 'active'];

}
