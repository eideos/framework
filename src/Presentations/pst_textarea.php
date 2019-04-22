<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_textarea extends Presentation {

    protected $view = "framework::presentations.textarea";

    public function getViewFieldPath() {
      if (!$this->isvisible) {
          return "framework::presentations.hidden";
      }
      if ($this->list) {
          return "framework::presentations.list";
      }
      if ($this->readonly) {
          return "framework::presentations.textarea_readonly";
      }
      return parent::getViewFieldPath();
    }

}
