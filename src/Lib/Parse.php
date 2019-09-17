<?php

namespace Eideos\Framework\Lib;

class Parse {

    private $path;
    private $model;
    private $file;
    private $dataPath;

    public function __construct($path) {
        $this->path = $path;
        $this->dataPath = self::getDataPath();
        list($this->model, $this->file) = explode(".", $path);
        $this->parseXML();
    }

    private static function getDataPath() {
        return app_path() . DIRECTORY_SEPARATOR . "Data" . DIRECTORY_SEPARATOR;
    }

    public static function getData($path) {
        list($xmlfilename, $className) = explode(".", $path);
        $parse = new Parse($path);
        include_once(self::getDataPath() . $xmlfilename . DIRECTORY_SEPARATOR . $className . ".php");
        $className = "\\App\\Data\\" . $className;
        $obj = new $className;
        $data = $obj->getData();
        if (isset($data['data'])) {
            foreach ($data['data'] as $key => $dataarray) {
                $data['data'][$key] = $dataarray;
            }
        }
//        if (isset($data['conditions'])) {
//            foreach ($data['conditions'] as $campo => $valores) {
//                if (is_array($valores)) {
//                    foreach ($valores as $key => $valor) {
//                        $valores[$key] = replaceGlobalVars($valor);
//                    }
//                } else {
//                    $valores = replaceGlobalVars($valores);
//                }
//                $data['conditions'][$campo] = $valores;
//            }
//        }

        return $data;
    }

    public static function getDataImportar($path) {
        $class_name = substr($path, stripos($path, "/") + 1);
        if (!class_exists($class_name)) {
            App::import('Data', $path);
        }
        $obj = new $class_name;
        return $obj->getDataImportar();
    }

    private function importFiles($xmlStr) {
        $imports = null;
        $replaced = [];
        preg_match_all('/<import file=\"(.+?).xml\"\s?\/>/', $xmlStr, $imports);
        if (empty($imports)) {
            return $xmlStr;
        }
        foreach ($imports[0] as $key => $value) {
            if (!in_array($value, $replaced)) {
                $xmlImportFile = $this->dataPath . $imports[1][$key] . ".xml";
                if (file_exists($xmlImportFile)) {
                    $xmlImportStr = $this->importFiles(file_get_contents($xmlImportFile));
                    $xmlStr = str_replace($value, $xmlImportStr, $xmlStr);
                } else {
                    $xmlStr = str_replace($value, "", $xmlStr);
                }
                $replaced[] = $value;
            }
        }
        return $xmlStr;
    }

    private function parseXML() {
// Si no estoy en modo DEBUG no parseo el XML
        if (!config('app.debug')) {
            return;
        }

        $xmlFile = $this->dataPath . $this->model . ".xml";

// Si no encontro el archivo retorna
        if (!file_exists($xmlFile)) {
            return;
        }

// Obtengo el string del archivo general
        $xmlStr = file_get_contents($xmlFile);

// Reemplazo los imports por el string de cada uno de ellos
        $xmlStr = $this->importFiles($xmlStr);

        $attributes = array(
            'tab' => array('id', 'label', 'icon'),
            'importcolumn' => array('index', 'name', 'label', 'presentation'),
            'maintfield' => array('name', 'label', 'presentation', 'params', 'class', 'isvisible', 'readonly', 'size', 'actions', 'note', 'initialvalue', 'autocomplete', 'placeholder', 'rows', 'cols', 'model', 'displayField', 'listen', 'listenCallback', 'multiple'),
            'table' => array('id', 'paginate', 'title', 'label', 'popup', 'columns', 'blocks', 'model', 'order', 'orderby', 'assoc', 'multiple', 'total', 'directedit', 'cols', 'readonly', 'relation', 'width', 'icon', 'button'),
            'tableaction' => array('op', 'displayFunction'),
            'files' => array('id', 'paginate', 'title', 'order', 'orderby', 'blocks', 'model', 'allowedTypes', 'descEnabled', 'readonly'),
            'tablefield' => array('name', 'label', 'presentation', 'params', 'isvisible', 'isvisibletable', 'readonly', 'size', 'actions', 'note', 'initialvalue', 'placeholder', 'total', 'model', 'rows', 'cols', 'displayField', 'uniqueInTable', 'listen', 'listenCallback', 'multiple'),
            'searchfield' => array('name', 'label', 'presentation', 'params', 'isvisible', 'readonly', 'size', 'note', 'initialvalue', 'autocomplete', 'placeholder', 'rows', 'cols', 'model', 'displayField'),
            'listfield' => array('name', 'label', 'presentation', 'params', 'isvisible', 'directedit', 'skip-export', 'split-on-export', 'model', 'displayField', 'search', 'class'),
            'slactions' => array('op', 'action', 'controller', 'params', 'icon', 'label', 'next', 'post', 'global', 'displayFunction', 'class', 'method', 'blank'),
            'fieldset' => array('id', 'label', 'columns', 'blocks', 'cols', 'readonly', 'icon'),
        );

        try {
            $obj = @new \SimpleXMLElement($xmlStr);
        } catch (Exception $e) {
            throw new Exception("El archivo XML no pudo ser parseado correctamente.");
            return false;
        }

        foreach ($obj as $objPartKey => $objPart) {
            if ($objPartKey === "search_list") {
                $sl = $objPart;
                $file = (string) $sl['file'];
                $title = isset($sl['title']) ? (string) $sl['title'] : "";
                $data = array("title" => $title);
                $data['info'] = isset($sl['info']) ? $this->getCastedValue((string) $sl['info']) : "";
                $data['warning'] = isset($sl['warning']) ? $this->getCastedValue((string) $sl['warning']) : "";
// Agrego procesado de js en s&l
                if (isset($sl->jsinclude)) {
                    foreach ($sl->jsinclude as $jsinclude) {
                        $data['jsincludes'][] = (string) $jsinclude['file'];
                    }
                }
                if (isset($sl->cssinclude)) {
                    foreach ($sl->cssinclude as $cssinclude) {
                        $data['cssincludes'][] = (string) $cssinclude['file'];
                    }
                }
                if (isset($sl->conditions)) {
                    $aconditions = [];
                    foreach ($sl->conditions->condition as $condition) {
                        $field = (string) $condition['field'];
                        $operator = (string) $condition['operator'];
                        $values = (string) $condition['values'];
                        $aconditions[$field] = [
                            "operator" => $operator,
                            "values" => $this->getCastedValue($values),
                        ];
                    }
                    $data['conditions'] = $aconditions;
                }
                if (isset($sl->actions)) {
                    $aactions = [];
                    foreach ($sl->actions->action as $action) {
                        $newAction = [];
                        foreach ($attributes['slactions'] as $attribute) {
                            if (isset($action[$attribute])) {
                                $newAction[$attribute] = (string) $action[$attribute];
                            }
                        }
                        $aactions[] = $newAction;
                    }
                    $data['actions'] = $aactions;
                } else {
                    $data['actions'] = get_default_actions();
                }
                if (isset($sl->searchfield)) {
                    foreach ($sl->searchfield as $searchfield) {
                        $filter = [];
                        foreach ($attributes['searchfield'] as $attribute) {
                            if (isset($searchfield[$attribute])) {
                                $filter[$attribute] = $this->getCastedValue($searchfield[$attribute]);
                            }
                        }
                        $data['searchfields'][] = $filter;
                    }
                }
                if (isset($sl->listfield)) {
                    foreach ($sl->listfield as $listfield) {
                        $column = [];
                        foreach ($attributes['listfield'] as $attribute) {
                            if (isset($listfield[$attribute])) {
                                $column[$attribute] = $this->getCastedValue($listfield[$attribute]);
                            }
                        }
                        $data['listfields'][] = $column;
                    }
                }
                if (isset($sl->table) && isset($sl->table->column)) {
                    foreach ($sl->table->column as $column) {
                        $acolumn = array(
                            'label' => isset($column['label']) ? $this->getCastedValue($column['label']) : '',
                            'sortfield' => isset($column['sortfield']) ? $this->getCastedValue($column['sortfield']) : '',
                        );
                        foreach ($column->listfield as $listfield) {
                            $alistfield = [];
                            foreach ($attributes['listfield'] as $attribute) {
                                if (isset($listfield[$attribute])) {
                                    $alistfield[$attribute] = $this->getCastedValue($listfield[$attribute]);
                                }
                            }
                            $acolumn['fields'][] = $alistfield;
                        }
                        $data['listfields'][] = $acolumn;
                    }
                }
                if (isset($sl['orderby'])) {
                    $aorder = [];
                    foreach (explode(",", (string) $sl['orderby']) as $order) {
                        list($order_key, $order_value) = explode(" ", preg_replace('/\s+/', ' ', trim($order)));
                        $aorder[trim($order_key)] = trim($order_value);
                    }
                    $data['order'] = $aorder;
                }
                $this->writeFile($file, $data);
            }
            if ($objPartKey === "tablemaint") {
                $maint = $objPart;
                $file = (string) $maint['file'];
                $model = substr($file, 0, strpos($this->file, ".xml"));
                $data = [];
                $import = [];
                if (isset($maint['title'])) {
                    $data['title'] = (string) $maint['title'];
                }
                $data['submit'] = isset($maint['submit']) ? $this->getCastedValue((string) $maint['submit']) : "Guardar";
                $data['cancel'] = isset($maint['cancel']) ? $this->getCastedValue((string) $maint['cancel']) : true;
                $data['info'] = isset($maint['info']) ? $this->getCastedValue((string) $maint['info']) : "";
                $data['warning'] = isset($maint['warning']) ? $this->getCastedValue((string) $maint['warning']) : "";
                if (isset($maint['next'])) {
                    $data['next'] = (string) $maint['next'];
                }
                if (isset($maint->cssinclude)) {
                    foreach ($maint->cssinclude as $cssinclude) {
                        $data['cssincludes'][] = (string) $cssinclude['file'];
                    }
                }
                if (isset($maint->jsinclude)) {
                    foreach ($maint->jsinclude as $jsinclude) {
                        $data['jsincludes'][] = (string) $jsinclude['file'];
                    }
                }
                if (isset($maint->tab)) {
                    foreach ($maint->tab as $tab) {
                        $atab = array(
                            'type' => 'tab',
                            'blocks' => [],
                        );
                        foreach ($attributes['tab'] as $attribute) {
                            if (isset($tab[$attribute])) {
                                $atab[$attribute] = (string) $tab[$attribute];
                            }
                        }
                        foreach ($tab as $tabObjKey => $tabObj) {
                            if ($tabObjKey === "fieldset") {
                                $fieldset = $tabObj;
                                $afieldset = array(
                                    'type' => 'fieldset',
                                    'fields' => [],
                                );
                                foreach ($attributes['fieldset'] as $attribute) {
                                    if (isset($fieldset[$attribute])) {
                                        $afieldset[$attribute] = (string) $fieldset[$attribute];
                                    }
                                }
                                if (isset($fieldset->field)) {
                                    foreach ($fieldset->field as $field) {
                                        $afield = [];
                                        foreach ($attributes['maintfield'] as $attribute) {
                                            if (isset($field[$attribute])) {
                                                $afield[$attribute] = $this->getCastedValue($field[$attribute]);
                                            }
                                        }
                                        if (isset($fieldset['order'])) {
                                            $objPartKey = (int) $fieldset['order'];
                                            while (isset($afieldset['fields'][$objPartKey])) {
                                                $objPartKey++;
                                            }
                                            $afieldset['fields'][$objPartKey] = $afield;
                                        } else {
                                            $afieldset['fields'][] = $afield;
                                        }
                                    }
                                }
                                $atab['blocks'][] = $afieldset;
                            }
                            if ($tabObjKey === "table") {
                                $table = $tabObj;
                                $atable = array(
                                    'fields' => []
                                );
                                foreach ($attributes['table'] as $attribute) {
                                    if (isset($table[$attribute])) {
                                        $atable[$attribute] = $this->getCastedValue($table[$attribute]);
                                    }
                                }
                                if (!isset($atable["popup"]) || $atable["popup"]) {
                                    $atable['type'] = "tablepopup";
                                } else {
                                    $atable['type'] = "table";
                                }
                                if (isset($atable['orderby'])) {
                                    $aorder = [];
                                    foreach (explode(",", (string) $atable['orderby']) as $order) {
                                        list($order_key, $order_value) = explode(" ", preg_replace('/\s+/', ' ', trim($order)));
                                        $aorder[trim($order_key)] = trim($order_value);
                                    }
                                    $atable['order'] = $aorder;
                                }
                                if (isset($atable['width']) && !empty($atable['width'])) {
                                    $atable['width'] = (is_numeric($atable['width']) ? $atable['width'] . "px" : $atable['width']);
                                }
                                if (isset($table->field)) {
                                    foreach ($table->field as $field) {
                                        $afield = [];
                                        foreach ($attributes['tablefield'] as $attribute) {
                                            if (isset($field[$attribute])) {
                                                $afield[$attribute] = $this->getCastedValue($field[$attribute]);
                                            }
                                        }
                                        $atable['fields'][] = $afield;
                                    }
                                }
                                /*
                                  if (isset($table->action)) {
                                  foreach ($table->action as $action) {
                                  $aaction = [];
                                  foreach ($attributes['tableaction'] as $attribute) {
                                  if (isset($action[$attribute])) {
                                  $aaction[$attribute] = $this->getCastedValue($action[$attribute]);
                                  }
                                  }
                                  $atable['actions'][] = $aaction;
                                  }
                                  }
                                 */
                                if (isset($table->action)) {
                                    $atable['actions'] = [
                                        "add" => false,
                                        "update" => false,
                                        "delete" => false,
                                    ];
                                }
                                if (isset($table->actions)) {
                                    $atable['actions'] = [
                                        "add" => false,
                                        "update" => false,
                                        "delete" => false,
                                    ];
                                    foreach ($table->actions->action as $action) {
                                        switch (strtoupper($action['op'])) {
                                            case "A":
                                                $atable['actions']["add"] = true;
                                                break;
                                            case "M":
                                                $atable['actions']["update"] = true;
                                                break;
                                            case "D":
                                                $atable['actions']["delete"] = true;
                                                break;
                                        }
                                    }
                                }
                                if (isset($table->parentAction)) {
                                    foreach ($table->parentAction as $parentAction) {
                                        $atable['parentActions'][] = (string) $parentAction['op'];
                                    }
                                }
                                if (isset($table->conditions)) {
                                    $aconditions = [];
                                    foreach ($table->conditions->condition as $condition) {
                                        $field = (string) $condition['field'];
                                        $operator = (string) $condition['operator'];
                                        $values = (string) $condition['values'];
                                        $aconditions[$field] = [
                                            "operator" => $operator,
                                            "values" => $values,
                                        ];
                                    }
                                    $atable['conditions'] = $aconditions;
                                }
                                if (isset($table->filters)) {
                                    $afilters = [];
                                    foreach ($table->filters->filter as $filter) {
                                        $field = (string) $filter['field'];
                                        $values = (string) $filter['values'];
                                        $afilters[$field] = explode(",", $values);
                                    }
                                    $atable['filters'] = $afilters;
                                }
                                $atab['blocks'][] = $atable;
                            }
                            if ($tabObjKey === "files") {
                                $files = $tabObj;
                                $afiles = array(
                                    'type' => 'files',
                                );
                                foreach ($attributes['files'] as $attribute) {
                                    if (isset($files[$attribute])) {
                                        $afiles[$attribute] = $this->getCastedValue($files[$attribute]);
                                    }
                                }
                                $atab['blocks'][] = $afiles;
                            }
                        }
                        if (isset($atab['id'])) {
                            $data['data'][$atab['id']] = $atab;
                        } else {
                            $data['data'][] = $atab;
                        }
                    }
                }
                if (isset($maint->importcolumns)) {
                    foreach ($maint->importcolumns as $importColumns) {
                        foreach ($importColumns as $importColumn) {
                            $aColumn = [];
                            foreach ($attributes['importcolumn'] as $attribute) {
                                if (isset($importColumn[$attribute])) {
                                    if ($attribute != "index") {
                                        $aColumn[$attribute] = $this->getCastedValue($importColumn[$attribute]);
                                    }
                                }
                            }
                            $import['import'][$this->getCastedValue($importColumn["index"])] = $aColumn;
                        }
                    }
                }
            }
            $this->writeFile($file, $data, $import ?? null);
        }
    }

    private function writeFile($file, $data, $import = null) {
        $class = substr($file, 0, strpos($file, ".php"));

        $php = "<?php\n";
        $php .= "\n";
        $php .= "/* GENERADO AUTOMATICAMENTE */\n";
//$php.= "/* " . date("d/m/Y H:i:s") . " */\n";
        $php .= "\n";
        $php .= "namespace App\Data;\n";
        $php .= "\n";
        $php .= "use Eideos\Framework\Lib\AbstractData;\n";
        $php .= "\n";
        $php .= "class " . $class . " extends AbstractData {\n";
        $php .= "\n";
        $php .= "protected \$data = ";
        $php .= str_replace("  ", "    ", var_export($data, true));
        $php .= ";\n";
        if (!is_null($import) && isset($import['import'])) {
            $php .= "\n";
            $php .= "protected \$import =\n";
            $php .= var_export($import['import'], true);
            $php .= ";\n";
        }
        $php .= "\n";
        $php .= "}\n";

        if (!file_exists($this->dataPath . $this->model)) {
            mkdir($this->dataPath . $this->model);
        }
        @chmod($this->dataPath . $this->model, 0777);
        if (!file_exists($this->dataPath . $this->model . DIRECTORY_SEPARATOR . $file) || is_writable($this->dataPath . $this->model . DIRECTORY_SEPARATOR . $file)) {
            file_put_contents($this->dataPath . $this->model . DIRECTORY_SEPARATOR . $file, $php);
        }
    }

    private function getCastedValue($var) {
        if (is_object($var)) {
            $var = (string) $var;
        }
        if (is_numeric($var)) {
            if (is_float($var + 0)) {
                return (float) $var;
            }
            return (int) $var;
        }
        if ($var == "true" || $var == "false") {
            return $var == 'true';
        }
        return str_replace("\\", "__", $var);
    }

}
