<?php

namespace Eideos\Framework\Presentations;

class pst_tags extends Presentation
{
    public $js_initial = "tags_init";
    public $js_totext = "tags_totext";
    public $js_tovalue = "tags_tovalue";
    public $js_topopup = "tags_topopup";

    public function getJsIncludes()
    {
        return ["vendor/framework/js/presentation/tags.js"];
    }
}
