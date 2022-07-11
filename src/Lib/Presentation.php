<?php

namespace Eideos\Framework\Lib;

class Presentation {

    public $name;
    public $label;
    protected $view;
    protected $params = [];
    protected $cols = 12;
    protected $rows = 2;
    protected $class = "";
    protected $readonly = false;
    protected $search = true;
    protected $searchfield = false;
    protected $initialvalue;
    protected $value;
    protected $placeholder;
    protected $note;
    protected $list = false;
    protected $tableModel;
    protected $rowNumber;
    public $isNumeric = false;
    public $actions;
    public $isvisible = true;
    public $isvisibletable = true;
    public $js_initial;
    public $js_totext = "presentation_totext";
    public $js_tovalue = "presentation_tovalue";
    public $js_topopup = "presentation_topopup";

    public function __construct($params) {
        foreach ($params as $key => $value) {
            if($key == "listen") {
                $this->{$key} = $value;
            } else {
                $this->{$key} = str_replace("__", "\\", $value);
            }
        }
    }

    public function getJsIncludes() {
        return [];
    }

    public function getCssIncludes() {
        return [];
    }

    public function getViewFieldPath() {
        if (!$this->isvisible) {
            return "framework::presentations.hidden";
        }
        if ($this->list) {
            return "framework::presentations.list";
        }
        if ($this->readonly) {
            return "framework::presentations.readonly";
        }
        if (view()->exists($this->view)) {
            return $this->view;
        }
        return "framework::presentations.text";
    }

    public function getViewVars() {
        return [
            "name" => $this->getName(),
            "label" => $this->label,
            "cols" => $this->cols,
            "class" => $this->class,
            "rows" => $this->rows,
            "value" => $this->getValue(),
            "helperValue" => $this->getHelperValue(),
            "list" => $this->list,
            "note" => $this->note,
            "placeholder" => $this->placeholder,
            "params" => $this->getJsParams(),
            "jsincludes" => $this->getJsIncludes(),
            "cssincludes" => $this->getCssIncludes(),
        ];
    }

    public function getJsParams() {
        return @json_decode(str_replace('\'', '"', $this->params), true) ?? [];
    }

    public function loadDatabaseValue() {
        if (isset($this->value)) {
            return $this->value;
        }
        return null;
    }

    public function getDatabaseValue() {
        if (isset($this->value)) {
            return is_array($this->value) ? implode(",", $this->value) : $this->value;
        }
        return null;
    }

    public function getDatabaseWhere($queryField = null) {
        $queryField = $queryField ?? $this->getOriginalName();
        $value = $this->getValue();
        if ($this->isNumeric) {
            return $queryField . " = '" . $value . "'";
        }
        return $queryField . " LIKE '%" . $value . "%'";
    }

    public function getSearchBarFieldName() {
        return $this->getName();
    }

    public function getSearchBarValue($search = "") {
        return "LIKE '%" . $search . "%'";
    }

    // Setters y Getters

    public function getOriginalName() {
        return $this->name;
    }

    public function getName() {
        if (!empty($this->tableModel)) {
            return get_list_field_name($this->tableModel, $this->name, $this->rowNumber);
        } elseif (!empty($this->rowNumber)) {
            return get_list_field_name(null, $this->name, $this->rowNumber);
        }
        return $this->name ?? "";
    }

    public function getLabel() {
        return $this->label ?? "";
    }

    public function getValue() {
        $databaseValue = $this->loadDatabaseValue();
        if (isset($databaseValue) && $databaseValue !== "") {
            return $databaseValue;
        }
        $initialValue = $this->getInitialValue();
        if (isset($initialValue) && $initialValue !== "") {
            return $initialValue;
        }
        return "";
    }

    public function getInitialValue() {
        return $this->initialvalue;
    }

    public function getHelperValue() {
        return $this->getValue();
    }

    public function getSearch() {
        return $this->search ?? true;
    }

    public function getJsInitial() {
        return $this->js_initial ?? null;
    }

    public function getTableModel() {
        return $this->tableModel ?? null;
    }

    public function getIsVisible() {
        return $this->isvisible ?? true;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function setList($list) {
        $this->list = $list;
    }

    public function setTableModel($tableModel) {
        $this->tableModel = $tableModel;
    }

    public function setReadonly($readonly) {
        $this->readonly = $readonly;
    }

    public function setRowNumber($rowNumber) {
        $this->rowNumber = $rowNumber;
    }

}
