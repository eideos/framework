<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_money extends Presentation {

    protected $view = "framework::presentations.money";
    protected $symbol = "$";
    protected $reverse = true;
    protected $mask = "#.##0,00";
    public $js_initial = "money_init";
    public $js_totext = "money_totext";

    public function getJsIncludes() {
        return ["vendor/framework/js/presentation/money.js"];
    }

    public function getHelperValue() {
        return number_format((float)$this->getValue(), 2, ",", ".");
    }

    public function getViewFieldPath() {
        if (!$this->isvisible) {
            return "framework::presentations.hidden";
        }
        if ($this->list) {
            return $this->view . "_list";
        }
        if ($this->readonly) {
            return $this->view . "_readonly";
        }
        if (view()->exists($this->view)) {
            return $this->view;
        }
        return "framework::presentations.text";
    }

    public function getJsParams() {
        return array_merge(parent::getJsParams(), [
            "mask" => $this->mask ?? "#.##0,00",
            "reverse" => $this->reverse ?? true,
        ]);
    }

    public function getViewVars() {
        $parentVars = parent::getViewVars();
        return array_merge($parentVars, ["symbol" => $this->symbol, "mask" => $this->mask]);
    }

}
