<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_int extends Presentation {

    protected $view = "framework::presentations.int";
    public $isNumeric = true;
    public $prepend = "123";

    public function getViewVars() {
        return array_merge(parent::getViewVars(), [
            "prepend" => $this->prepend,
        ]);
    }

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
