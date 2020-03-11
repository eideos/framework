<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;
use Carbon\Carbon;

class pst_date extends Presentation {

    protected $view = "framework::presentations.date";
    public $js_initial = "date_init";

    public function getSearchBarValue($search = "") {
        return "LIKE '%" . self::transformValue($search) . "%'";
    }

    public function getInitialValue() {
        $params = $this->getJsParams();
        if (empty($this->initialvalue) && isset($params['force']) && $params['force']) {
            return date("d/m/Y");
        }
        return $this->initialvalue;
    }

    public function getJsIncludes() {
        return ["vendor/framework/js/presentation/date.js"];
    }

    public function getDatabaseValue() {
        return self::transformValue($this->value);
    }

    public function loadDatabaseValue() {
        if (!empty($this->value)) {
            //validacion para que ande el search
            if (strpos($this->value, "/") !== false) {
                return $this->value;
            }
            return date("d/m/Y", strtotime($this->value));
        }
        return "";
    }

    public function getDatabaseWhere($queryField = null) {
        return $queryField . " = '" . $this->getDatabaseValue() . "'";
    }

    public static function transformValue($value) {
        if (empty($value)) {
            return null;
        }
        $array = explode("/", $value);
        return implode("-", array_reverse($array));
    }

}
