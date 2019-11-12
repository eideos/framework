<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_selectarray extends Presentation {

    protected $view = "framework::presentations.selectarray";
    protected $values = [];
    protected $uniqueInTable = false;
    public $js_initial = "selectarray_init";
    public $js_totext = "selectarray_totext";

    public function getJsIncludes() {
        return ["vendor/framework/js/presentation/selectarray.js"];
    }

    public function getOptionValue($value) {
        return $this->values[$value];
    }

    public function getViewVars() {
        return array_merge(parent::getViewVars(), [
            "options" => $this->values ?? [],
            "uniqueInTable" => $this->uniqueInTable,
        ]);
    }

    public function getHelperValue() {
        $value = $this->getValue();
        if (isset($value)) {
            if (in_array($value, array_keys($this->values)) && isset($this->values[$value])) {
                return $this->values[$value];
            } else {
                return $value;
            }
        }
        return "";
    }

    public function getSearchBarValue($search = "") {
        $values = [];
        foreach ($this->values as $value => $display) {
            if (strstr(strtolower($display), strtolower($search)) !== false) {
                $values[] = $value;
            }
        }
        return " IN ('" . implode("','", $values) . "')";
    }

}
