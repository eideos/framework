<?php

namespace Eideos\Framework\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

class NotificationController extends AppController {

    protected $model = "Eideos\Framework\Notification";
    protected $url = "notifications";

    public function index(Request $request) {
        $this->bladeVars["title"] = "Notificaciones";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Notificaciones"],
        ];
        $this->slfile = "Notification.NotificationSL";
        return parent::index($request);
    }

    public function export(Request $request, $type) {
        $this->slfile = "Notification.NotificationSL";
        return parent::export($request, $type);
    }

}
