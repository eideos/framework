<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_autocomplete extends Presentation
{
    protected $view = "framework::presentations.autocomplete";
    protected $model;
    protected $displayField;
    protected $conditions = [];
    protected $listen;
    protected $listenCallback;
    protected $active = false;
    protected $isNumeric = true;
    protected $params;
    protected $data = [];
    public $js_initial = "autocomplete_init";
    public $js_totext = "autocomplete_totext";

    public function getJsIncludes()
    {
        return ["vendor/framework/js/presentation/autocomplete.js"];
    }

    public function getViewVars()
    {
        $vars = [
            "model" => $this->model,
            "listen" => $this->listen,
            "listenCallback" => $this->listenCallback,
            "displayField" => $this->getDisplayField(),
            "addButton" => $this->hasAddButton(),
        ];
        if ($this->hasActiveSetted()) {
            $vars['active'] = $this->active;
        }
        return array_merge(parent::getViewVars(), $vars);
    }

    public function getJsParams()
    {       
        if(isset($this->params["conditions"])) {
            $conditions = array_merge($this->params["conditions"], $this->conditions);
        }
        return array_merge(parent::getJsParams(), [
          "active" => $this->active ?? 1,
          "conditions" => $conditions ?? [],
          "joins" => $this->joins ?? [],
      ]);
    }

    public function hasAddButton()
    {
        if (isset($this->params)) {
            $arr_params = json_decode($this->params, true);
            if (isset($arr_params["addButton"]) && $arr_params["addButton"]) {
                return true;
            }
        }
        return false;
    }

    public function getDisplayField()
    {
        return $this->displayField ?? "id";
        /*
          $class = "\\App\\" . $this->model;
          $modelObj = new $class();
          if (isset($this->displayField) && \Schema::hasColumn($modelObj->getTable(), $this->displayField)) {
          return $this->displayField;
          }
          return "id";
         */
    }

    protected function hasActiveSetted()
    {
        return (!isset($this->active) || is_bool($this->active) && $this->active);
    }

    public function getHelperValue()
    {
        $value = $this->getValue();
        if (isset($value) && is_numeric($value)) {
            $displayField = $this->getDisplayField();
            $class = $this->model;
            if (class_exists($class)) {
                $methodTransform = "transform" . ucfirst(camel_case($displayField)) . "Attribute";
                $modelObj = new $class();
                if (method_exists($modelObj, $methodTransform)) {
                    $displayField = $modelObj->{$methodTransform}();
                }
            }
            return $this->model::where(["id" => $value])->selectRaw(($displayField ?? "id") . " AS displayField")->first()['displayField'];
        }
        return $value;
    }
}
