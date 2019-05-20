<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_daterange extends Presentation {

    protected $view = "framework::presentations.daterange";
    public $js_initial = "daterange_init";

    public function getJsIncludes() {
        return ["vendor/framework/js/presentation/daterange.js"];
    }

    public function getViewVars() {
        return array_merge(parent::getViewVars(), [
            "value_from" => $this->value["from"],
            "value_to" => $this->value["to"],
        ]);
    }

    public function getHelperValue() {
        $value = $this->getValue();
        $parts = [];
        if (!empty($this->value["from"])) {
            $parts[] = "Desde: " . $this->value["from"];
        }
        if (!empty($this->value["to"])) {
            $parts[] = "Hasta: " . $this->value["to"];
        }
        return implode(" | ", $parts);
    }

    public function loadDatabaseValue() {
        if (isset($this->value)) {
            return implode(",", $this->value);
        }
        return null;
    }

    public function getDatabaseWhere($queryField = null) {
        $queryField = $queryField ?? $this->getOriginalName();
        $parts = [];
        if (!empty($this->value["from"])) {
            $parts[] = $queryField . " >= '" . self::transformValue($this->value["from"]) . " 00:00:00'";
        }
        if (!empty($this->value["to"])) {
            $parts[] = $queryField . " <= '" . self::transformValue($this->value["to"]) . " 23:59:59'";
        }
        return implode(" AND ", $parts);
    }

    public static function transformValue($value) {
        if (empty($value)) {
            return null;
        }
        $array = explode("/", $value);
        return implode("-", array_reverse($array));
    }

}
