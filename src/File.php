<?php

namespace Eideos\Framework;

use App\AppModel;

class File extends AppModel {

    protected $fillable = ['created_by', 'updated_by', 'name', 'mimetype', 'size', 'extension', 'storage', 'observation'];

}
