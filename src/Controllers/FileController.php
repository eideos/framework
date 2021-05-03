<?php

namespace Eideos\Framework\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller {

    public function destroy(Request $request) {
        if (!$request->ajax()) {
            return redirect()->back()->with('danger', '¡Método sólo habilitado desde el formulario correspondiente!');
        }
        if (isset_notempty($request->table) && isset_notempty($request->id)) {
            $className = "App\\" . singular_studly_from_snake_plural_case($request->table);
            $file = (new $className())->find($request->id);
            if (@unlink(storage_path('app' . DIRECTORY_SEPARATOR . $file->storage))) {
                if ($file->delete()) {
                    return response()->json(["status" => "OK", "message" => "¡Archivo eliminado correctamente!"]);
                }
            }
        }
        return response()->json(["status" => "ERROR", "message" => "¡El archivo no pudo ser eliminado!"]);
    }

    public function display($table, $id) {
        $className = "App\\" . singular_studly_from_snake_plural_case($table);
        $fileData = (new $className())->find($id);
        $download_path = storage_path('app' . DIRECTORY_SEPARATOR . $fileData->storage);
        if (ob_get_contents()) {
            ob_end_clean();
        }
        return response()->file($download_path);
    }

    public function download($table, $id) {
        $className = "App\\" . singular_studly_from_snake_plural_case($table);
        $fileData = (new $className())->find($id);
        $download_path = storage_path('app' . DIRECTORY_SEPARATOR . $fileData->storage);
        if (ob_get_contents()) {
            ob_end_clean();
        }
        return response()->download($download_path);
    }

    public function image($storagePath, $thumbnail = null, $relativePath = null)
    {
        if (!empty($storagePath)) {
            $download_path = storage_path('app' . DIRECTORY_SEPARATOR . base64_decode($storagePath));
            if (empty($relativePath)) {
                $download_path = base64_decode($storagePath);
            }
            if (!empty($thumbnail)) {
                $name = \File::name($download_path);
                $thumbPath = str_replace($name, $name . "_thumb", $download_path);
                if (file_exists($thumbPath)) {
                    $download_path = $thumbPath;
                }
            }
            if (file_exists($download_path)) {
                if (ob_get_contents()) {
                    ob_end_clean();
                }
                return response()->file($download_path);
            }
        }
        return back();
    }

    public function download_file($storagePath)
    {
        if (!empty($storagePath)) {
            $download_path = storage_path('app' . DIRECTORY_SEPARATOR . base64_decode($storagePath));
            if (!file_exists($download_path)) {
                $download_path = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . base64_decode($storagePath));
            }
            if (file_exists($download_path)) {
                if (ob_get_contents()) {
                    ob_end_clean();
                }
                return response()->download($download_path);
            }
        }
        return back();
    }

}
