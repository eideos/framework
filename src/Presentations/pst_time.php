<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_time extends Presentation
{

    protected $view = "framework::presentations.time";
    public $js_initial = "time_init";
    public $format = "H:i";

    public function getInitialValue()
    {
        $params = $this->getJsParams();
        if (empty($this->initialvalue) && isset($params['force']) && $params['force']) {
            return date($this->format);
        }
        return $this->initialvalue;
    }

    public function loadDatabaseValue()
    {
        if (!empty($this->value)) {
            return date($this->format, strtotime($this->value));
        }
        return "";
    }

    public function getJsIncludes()
    {
        return ["vendor/framework/js/presentation/time.js"];
    }
}
