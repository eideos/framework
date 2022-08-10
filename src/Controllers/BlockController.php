<?php

namespace Eideos\Framework\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppController;
use Eideos\Framework\Block;

class BlockController extends AppController
{
    protected $model = "Eideos\Framework\Block";
    protected $url = "blocks";

    public function index(Request $request)
    {
        $this->bladeVars["title"] = "Bloqueos";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Bloqueos"],
        ];
        $this->slfile = "Block.BlockSL";
        return parent::index($request);
    }

    public function destroy(Request $request, $id)
    {
        $this->successMessage = 'Bloqueo eliminado correctamente.';
        $this->errorMessage = 'El Bloqueo no pudo eliminarse.';
        return parent::destroy($request, $id);
    }

    public function export(Request $request, $type)
    {
        $this->slfile = "Block.BlockSL";
        return parent::export($request, $type);
    }

    public function check($model, $model_id)
    {
        $minutes = env("FMW_MINUTES_MAX_BLOCK", 15);
        if (empty($model) || empty($model_id)) {
            return response()->json(["status" => "error"]);
        }
        $block = Block::where('model', str_replace("__", "\\", $model))->where('model_id', $model_id)->first();
        if ($block) {
            $time = time() - strtotime($block->created_at);
            if ($time > ($minutes * 60)) {
                return response()->json(["status" => "expired"]);
            }
            return response()->json(["status" => "alert", "time" => gmdate("i:s", ($minutes * 60 - $time))]);
        }
        return response()->json(["status" => "error"]);
    }

    public function free($model, $model_id)
    {
        if (empty($model) || empty($model_id)) {
            return response()->json(["status" => "error"]);
        }
        $delete = Block::freeBlock(str_replace("__", "\\", $model), $model_id);
        if ($delete) {
            return response()->json(["status" => "ok"]);
        }
        return response()->json(["status" => "error"]);
    }
}
