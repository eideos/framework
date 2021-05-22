<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_checkbox extends Presentation
{
    protected $view = "framework::presentations.checkbox";
    protected $options = [];
    protected $model;
    protected $modelObj;
    protected $conditions = [];
    protected $orderBy = [];
    public $js_tovalue = "checkbox_tovalue";
    public $js_totext = "checkbox_totext";

    public function __construct($params)
    {
        foreach ($params as $key => $value) {
            $this->{$key} = str_replace("__", "\\", $value);
        }
        if (empty($this->modelObj) && !empty($this->model) && class_exists($this->model) && empty($this->options)) {
            $this->conditions = $this->getJsParams()['conditions'] ?? [];
            $this->orderBy = $this->getJsParams()['orderBy'] ?? [];
            $this->modelObj = new $this->model();
            if (\Schema::connection($this->modelObj->getConnectionName())->hasColumn($this->modelObj->getTable(), "active") && (!isset($this->active) || is_bool($this->active) && $this->active)) {
                $this->conditions["active"] = 1;
            }
            $data = $this->model::where($this->conditions);
            if (\Schema::connection($this->modelObj->getConnectionName())->hasColumn($this->modelObj->getTable(), $this->getDisplayField())) {
                if (!empty($this->orderBy)) {
                    list($field, $direction) = explode(" ", $this->orderBy);
                    $data->orderBy($field, $direction);
                } else {
                    $data->orderBy($this->getDisplayField());
                }
            }
            foreach ($data->get() as $row) {
                $this->options[$row->id] = $row->{$this->getDisplayField()};
            }
        }
    }

    public function getHelperValue()
    {
        return array_map(function ($v) {
            return $this->options[$v] ?? $v;
        }, $this->getValue());
    }

    public function getJsIncludes()
    {
        return ["vendor/framework/js/presentation/checkbox.js"];
    }
    
    public function getValue() {
        $databaseValue = $this->loadDatabaseValue();
        if (isset($databaseValue) && $databaseValue !== "" && !empty($databaseValue)) {
            return $databaseValue;
        }
        $initialValue = $this->getInitialValue();
        if (isset($initialValue) && $initialValue !== "") {
            return $initialValue;
        }
        return [];
    }

    public function getViewVars()
    {
        return array_merge([
            "options" => $this->getJsParams()['options'] ?? $this->options ?? [],
            "values" => $this->getValue(),
            "value" => implode(",", $this->getValue()),
            "helperValue" => implode(", ", $this->getHelperValue()),
        ], parent::getViewVars());
    }

    public function getInitialValue() {
        if (isset($this->initialvalue)) {
            return explode(",", $this->initialvalue);
        }
        return [];
    }

    public function loadDatabaseValue()
    {
        if (isset($this->value)) {
            return is_array($this->value) ? $this->value : explode(",", $this->value);
        }
        return [];
    }

    public function getDatabaseValue()
    {
        return is_array($this->value) ? implode(",", $this->value) : $this->value;
    }

    public function getDisplayField() {
        return $this->displayField ?? "id";
    }
}
