<?php

namespace Eideos\Framework\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

class AuditController extends AppController {

    protected $model = "Eideos\Framework\Audit";
    protected $url = "audits";

    public function index(Request $request) {
        $this->bladeVars["title"] = "Auditorías";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Auditoría"],
        ];
        $this->slfile = "Audit.AuditSL";
        return parent::index($request);
    }

    public function export(Request $request, $type) {
        $this->slfile = "Audit.AuditSL";
        return parent::export($request, $type);
    }

}
