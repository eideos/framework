<?php

namespace Eideos\Framework\Presentations;

use Eideos\Framework\Lib\Presentation;

class pst_googlemaps extends Presentation
{
    protected $view = "framework::presentations.googlemaps";
    public $js_initial = "googlemaps_init";

    public function getJsParams()
    {
        return params;
    }

    public function getJsIncludes()
    {
        return [
          "https://maps.googleapis.com/maps/api/js?key=" . env('GOOGLEMAPS_KEY', ''),
          "vendor/framework/js/presentation/googlemaps.js",
        ];
    }

    public function getViewFieldPath()
    {
        if ($this->readonly) {
            return "framework::presentations.googlemaps_readonly";
        }
        if ($this->list) {
            return "framework::presentations.googlemaps_list";
        }
        return parent::getViewFieldPath();
    }
}
