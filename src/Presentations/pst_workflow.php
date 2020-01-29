<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_workflow extends Presentation
{
    protected $view = "framework::presentations.workflow";
    protected $values = [];
    protected $workflow = [];
    protected $callback = null;
    public $js_initial = "workflow_init";

    public function __construct($params) {
        parent::__construct($params);
        if (!empty($this->params)){
            $dParams = json_decode(str_replace("'", '"', $this->params), true);
            if (isset($dParams['searchfield']) && $dParams['searchfield']) {
                $this->searchfield = true;
            }
        }
        if ($this->searchfield) {
            $this->view = "framework::presentations.selectarray";
        }
    }

    public function getJsIncludes()
    {
        return ["vendor/framework/js/presentation/workflow.js"];
    }

    public function getViewVars()
    {
        return array_merge(parent::getViewVars(), [
            "options" => $this->getOptions(),
            "callback" => $this->callback,
        ]);
    }

    public function getJsParams()
    {
        return array_merge(parent::getJsParams(), [
            "callback" => $this->callback,
        ]);
    }

    public function getHelperValue()
    {
        if (isset($this->value) && isset($this->values[$this->value])) {
            return $this->values[$this->value];
        }
        return $this->value;
    }

    public function getOptions()
    {
        if (is_null($this->values)) {
            return [];
        }
        if ($this->searchfield) {
            return $this->values;
        }
        $arrayOptions = [];
        if (isset($this->workflow[$this->value])) {
            $arrayOptions = $this->workflow[$this->value];
            foreach ($arrayOptions as $key => $workflow_option) {
                if (!isset($arrayOptions[$key]["label"]) || empty($arrayOptions[$key]["label"])) {
                    $arrayOptions[$key]["label"] = $this->values[$workflow_option["step"]];
                }
            }
        }
        if (!empty($this->value) && !$this->isSetActualValue($arrayOptions)) {
            $arrayOptions[] = ["step" => $this->value, "order" => 0, "label" => $this->values[$this->value]];
        }
        foreach ($arrayOptions as $key => $workflow_option) {
            if (isset($arrayOptions[$key]["isvisible"]) && !$arrayOptions[$key]["isvisible"]) {
                unset($arrayOptions[$key]);
            }
        }
        usort($arrayOptions, function ($a, $b) {
            if ($a["order"] == $b["order"]) {
                return 0;
            }
            return ($a["order"] < $b["order"]) ? -1 : 1;
        });
        return $arrayOptions;
    }

    protected function isSetActualValue($arrayOptions)
    {
        foreach ($arrayOptions as $option) {
            if ($option["step"] == $this->value) {
                return true;
            }
        }
        return false;
    }
}
