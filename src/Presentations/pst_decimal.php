<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_decimal extends Presentation {

    protected $view = "text";
    protected $decimals = 2;

    public function getDatabaseValue() {
        if (isset($this->value)) {
            if (empty($this->value)) {
                return number_format(0, $this->decimals, ".", "");
            }
            return number_format($this->value, $this->decimals, ".", "");
        }
        return number_format(0, $this->decimals, ".", "");
    }

}
