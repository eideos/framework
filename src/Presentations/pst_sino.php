<?php

namespace Eideos\Framework\Presentations;

class pst_sino extends pst_selectarray
{
    protected $values = [1 => "Si", 0 => "No"];

    public function getDatabaseValue()
    {
        if (isset($this->value) && $this->value != '') {
            return is_array($this->value) ? implode(",", $this->value) : $this->value;
        }
        return null;
    }
}
