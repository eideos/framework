<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_file extends Presentation {

    protected $view = "framework::presentations.file";
    protected $multiple = false;
    public $js_initial = "file_init";
    public $js_tovalue = "file_tovalue";
    public $js_topopup = "file_topopup";

    public function loadRequestValue() {
        return request($this->name . '_file') ?? [];
    }
    public function getViewFieldPath() {
        if ($this->list) {
            return "framework::presentations.file_list";
        }
        return parent::getViewFieldPath();
    }

    public function getDatabaseValue() {
        $requestValue = $this->loadRequestValue();
        if (isset($requestValue) && !empty($requestValue)) {
            $this->value = $requestValue;
        }
        if (isset($this->value)) {
            if (!is_array($this->value)) {
                if (is_string($this->value)) {
                    $this->value = json_decode($this->value, true);
                } else {
                    $this->value = [$this->value];
                }
            }
            $array = [];
            if (!empty($this->value)) {
                foreach ($this->value as $file) {
                    if (is_object($file)) {
                        $params =  $this->getJsParams();
                        if (isset($params["public"]) && $params["public"]) {
                            $array[] = $file->storeAs(snake_case(str_plural($this->name)), $file->getClientOriginalName(), 'public');
                        } else {
                            $array[] = $file->storeAs(snake_case(str_plural($this->name)), $file->getClientOriginalName());
                        }
                    } else {
                        $array[] = $file;
                    }
                }
            }
            return json_encode($array);
        }
        return null;
    }

    public function getJsIncludes() {
        return ["vendor/framework/js/presentation/file.js"];
    }

    public function getJsParams() {
        return array_merge(parent::getJsParams(), [
            "name" => $this->getName() . '_file' . (isset($this->multiple) && $this->multiple ? "[]" : ""),
            "multiple" => $this->multiple ?? false,
        ]);
    }

    public function getViewVars() {
        return array_merge(parent::getViewVars(), [
            "multiple" => $this->multiple ?? false,
        ]);
    }

}
