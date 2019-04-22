<?php

namespace App\Presentations;

use Eideos\Framework\Presentations\pst_selectarray;

class pst_audit_events extends pst_selectarray {

    protected $values = [
      'created' => 'Creado',
      'updated' => 'Editado',
      'deleted' => 'Borrado',
    ];

}
