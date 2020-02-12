<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_int extends Presentation {

    protected $view = "framework::presentations.int";
    public $isNumeric = true;

    public function getDatabaseValue() {
        if (isset($this->value)) {
            if (empty($this->value)) {
                return 0;
            }
            return $this->value;
        }
        return null;
    }

}
