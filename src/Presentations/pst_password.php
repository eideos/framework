<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_password extends Presentation {

    protected $view = "framework::presentations.password";

    public function loadDatabaseValue() {
        return "";
    }

    public function getDatabaseValue() {
        if (isset($this->value)) {
            return \Illuminate\Support\Facades\Hash::make($this->value);
        }
        return null;
    }

}
