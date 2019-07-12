<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_time extends Presentation {

    protected $view = "framework::presentations.time";
    public $js_initial = "time_init";

    public function getSearchBarValue($search = "") {
        return "LIKE '%" . self::transformValue($search) . "%'";
    }

    public function getInitialValue() {
        $params = $this->getJsParams();
        if (empty($this->initialvalue) && isset($params['force']) && $params['force']) {
            return date("H:i");
        }
        return $this->initialvalue;
    }

    public function getJsIncludes() {
        return ["vendor/framework/js/presentation/time.js"];
    }

}
