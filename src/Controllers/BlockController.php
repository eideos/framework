<?php

namespace Eideos\Framework\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppController;
use Eideos\Framework\Block;

class BlockController extends AppController {

    protected $model = "Eideos\Framework\Block";
    protected $url = "blocks";

    public function index(Request $request) {
        $this->bladeVars["title"] = "Bloqueos";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Bloqueos"],
        ];
        $this->slfile = "Block.BlockSL";
        return parent::index($request);
    }

    public function destroy(Request $request, $id) {
        $this->successMessage = 'Bloqueo eliminado correctamente.';
        $this->errorMessage = 'El Bloqueo no pudo eliminarse.';
        return parent::destroy($request, $id);
    }

    public function export(Request $request, $type) {
        $this->slfile = "Block.BlockSL";
        return parent::export($request, $type);
    }

    public function check($model, $model_id) {
        $minutes = 15;
        if (empty($model) || empty($model_id)) {
            return ["status" => "error"];
        }
        $block = Block::where('model', $model)->where('model_id', $model_id)->first();
        $time = time() - strtotime($block->created_at);
        if ($time > ($minutes * 60)) {
            $data = array("status" => "expired");
        } else {
            $data = array("status" => "alert", "time" => gmdate("i:s", ($minutes * 60 - $time)));
        }
        return response()->json($data);
    }

    public function free($model, $model_id) {
        if (empty($model) || empty($model_id)) {
            return ["status" => "error"];
        }
        $block = Block::where('model', $model)->where('model_id', $model_id)->first();
        $block->delete();
        return response()->json(["status" => "OK"]);
    }

}
