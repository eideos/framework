<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_datetime extends Presentation
{
    protected $view =  "framework::presentations.datetime";
    protected $seconds = false;
    public $js_initial = "datetime_init";

    public function getInitialValue()
    {
        $params = $this->getJsParams();
        if (empty($this->initialvalue) && isset($params['force']) && $params['force']) {
            return date("d/m/Y H:i");
        }
        return $this->initialvalue;
    }

    public function getJsIncludes()
    {
        return ["vendor/framework/js/presentation/datetime.js"];
    }

    public function getJsParams()
    {
        return array_merge(parent::getJsParams(), [
              "format" => 'dd/mm/yyyy HH:MM' . ($this->seconds ? ':SS' : ''),
          ]);
    }

    public function getDatabaseValue()
    {
        $array1 = explode(" ", $this->value);
        if (count($array1) == 2) {
            $array2 = explode("/", $array1[0]);
            if (count($array2) == 3) {
                return $array2[2] . "-" . $array2[1] . "-" . $array2[0] . " " . $array1[1];
            }
        }
        return $this->value;
    }

    public function loadDatabaseValue()
    {
        if (!empty($this->value)) {
            return date("d/m/Y H:i" . ($this->seconds ? ":s" : ""), strtotime($this->value));
        }
        return "";
    }
}
