<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_file extends Presentation
{

    protected $view = "framework::presentations.file";
    protected $multiple = false;
    public $language = "en";
    public $file_types = [];
    public $js_initial = "file_init";
    public $js_tovalue = "file_tovalue";
    public $js_topopup = "file_topopup";
    public $max_file_size = "1500";
    public $force_delete = false;
    public function __construct($params)
    {
        parent::__construct($params);
        if (isset($params["params"])) {
            $file_params = json_decode($params["params"], true);
            $this->language = $file_params['language'] ?? 'en';
            if (isset($file_params['max_file_size']) && !is_null($file_params['max_file_size'])) {
                $this->max_file_size = $file_params['max_file_size'];
            }
            if (isset($file_params['file_types']) && !is_null($file_params['file_types'])) {
                $this->file_types = explode(",", $file_params['file_types']) ?? [];
                if (!is_array($this->file_types)) {
                    $this->file_types = [$this->file_types];
                }
            }
            $this->force_delete = $file_params['force_delete'] ?? false;
        }
    }
    public function loadRequestValue()
    {
        return request($this->name . '_file') ?? [];
    }

    public function getViewFieldPath()
    {
        if ($this->list) {
            return "framework::presentations.file_list";
        }
        if ($this->readonly) {
            return "framework::presentations.file_readonly";
        }
        return parent::getViewFieldPath();
    }

    public function getDatabaseValue()
    {
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
                            $array[] = $file->storeAs(snake_case(str_plural($this->name)), getMD5FileName($file), 'public');
                        } else {
                            $array[] = $file->storeAs(snake_case(str_plural($this->name)), getMD5FileName($file));
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

    public function getJsIncludes()
    {
        return ["vendor/framework/js/presentation/file.js"];
    }

    public function getJsParams()
    {
        return array_merge(parent::getJsParams(), [
            "name" => $this->getName() . '_file' . (isset($this->multiple) && $this->multiple ? "[]" : ""),
            "multiple" => $this->multiple ?? false,
            "language" => $this->language ?? 'en',
            "file_types" => $this->file_types,
            "max_file_size" => $this->max_file_size ?? "1500",
            "force_delete" => $this->force_delete ?? false,
        ]);
    }

    public function getViewVars()
    {
        return array_merge(parent::getViewVars(), [
            "multiple" => $this->multiple ?? false,
            "maxFileSize" => $this->max_file_size ?? "1500",
            "force_delete" => $this->force_delete ?? false,
        ]);
    }
}
