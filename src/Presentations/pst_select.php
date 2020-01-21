<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_select extends Presentation {

    protected $view = "framework::presentations.select";
    protected $model;
    protected $modelObj;
    protected $displayField;
    protected $conditions = [];
    protected $orderBy = [];
    protected $listen;
    protected $listenCallback;
    protected $uniqueInTable = false;
    protected $isNumeric = true;
    protected $active;
    protected $data = [];
    public $js_initial = "select_init";
    public $js_totext = "select_totext";

    public function __construct($params = []) {
        parent::__construct($params);
        $this->conditions = $this->getJsParams()['conditions'] ?? [];
        $this->orderBy = $this->getJsParams()['orderBy'] ?? [];
        if (empty($this->modelObj) && !empty($this->model) && class_exists($this->model)) {
            $this->modelObj = new $this->model();
            if (\Schema::connection($this->modelObj->getConnectionName())->hasColumn($this->modelObj->getTable(), "active") && (!isset($this->active) || is_bool($this->active) && $this->active)) {
                $this->conditions["active"] = 1;
            }
        }
        if (!empty($this->model) && class_exists($this->model) && empty($this->data)) {
            $data = $this->model::where($this->conditions);
            if (!empty($this->orderBy)) {
                $fields = explode(",", $this->orderBy);
                foreach ($fields as $field) {
                    if (strstr(trim($field), " ") === false) {
                        $direction = "ASC";
                    } else {
                        list($field, $direction) = explode(" ", trim($field));
                    }
                    $data->orderBy($field, $direction);
                }
            } elseif (\Schema::connection($this->modelObj->getConnectionName())->hasColumn($this->modelObj->getTable(), $this->getDisplayField())) {

                $data->orderBy($this->getDisplayField());
            }
            $this->data = $data->get();
        }
    }

    public function getJsIncludes() {
        return ["vendor/framework/js/presentation/select.js"];
    }

    public function getViewVars() {
        return array_merge(parent::getViewVars(), [
            "model" => $this->model,
            "listen" => $this->listen,
            "listenCallback" => $this->listenCallback,
            "uniqueInTable" => $this->uniqueInTable,
            "displayField" => $this->getDisplayField(),
            "options" => $this->getOptions(),
        ]);
    }

    public function getJsParams() {
        return array_merge(parent::getJsParams(), [
            "active" => $this->active ?? 1,
        ]);
    }

    public function getOptions() {
        $options = [];
        foreach ($this->data as $value) {
            $options[$value->id] = $value->{$this->getDisplayField()} ?? $value->id;
        }
        $value = $this->getValue();
        if (!empty($value) && !isset($options[$value])) {
            $options[$value] = $value;
        }
        return $options;
    }

    public function getHelperValue() {
        if (!empty($this->value)) {
            $options = $this->getOptions();
            return $options[$this->value] ?? $this->value;
        }
        if (!empty($this->initialvalue)) {
            $options = $this->getOptions();
            return $options[$this->initialvalue] ?? "";
        }
        return "";
    }

    public function getDatabaseValue() {
        if (!empty($this->value)) {
            return $this->value;
        }
        return null;
    }

    public function getSearchBarValue($search = "") {
        $values = [];
        foreach ($this->getOptions() as $value => $display) {
            if (strstr(strtolower($display), strtolower($search)) !== false) {
                $values[] = $value;
            }
        }
        if(!empty($values)){
            return " IN ('" . implode("','", $values) . "')";
        }
        return '';   
    }

    public function getDisplayField() {
        return $this->displayField ?? "id";
        /*
          if (isset($this->displayField) && \Schema::hasColumn($this->modelObj->getTable(), $this->displayField) ) {
          return $this->displayField;
          }
          return "id";
         */
    }

}
