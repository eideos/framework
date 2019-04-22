<?php

namespace Eideos\Framework\Lib;

abstract class AbstractData {

    protected $data = array();
    protected $import = array();

    public function getData() {
        return $this->data;
    }

    public function getDataImportar() {
        return $this->import;
    }

}
