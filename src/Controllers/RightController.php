<?php

namespace Eideos\Framework\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

class RightController extends AppController {

    protected $model = "Eideos\Framework\Right";
    protected $url = "rights";
    protected $rules = [
        'name' => 'required|max:255',
        'table.Eideos__Framework__Permission.*.action' => 'required',
        'table.Eideos__Framework__Permission.*.controller' => 'required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $this->bladeVars["title"] = "Derechos";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Derechos"],
        ];
        $this->bladeVars["deleteMessage"] = "¿Está seguro que desea eliminar el derecho #name ?";
        $this->slfile = "Right.RightSL";
        return parent::index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->bladeVars["title"] = "Nuevo Rol";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Derechos", "url" => "/rights"],
            ["label" => "Nuevo Rol", "active" => true],
        ];
        $this->maintfile = "Right.RightMaint";
        return parent::create();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        unset($this->rules['password']);
        $this->bladeVars["title"] = "Modificar Rol";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Derechos", "url" => "/rights"],
            ["label" => "Modificar Derecho", "active" => true],
        ];
        $this->maintfile = "Right.RightMaint";
        return parent::edit($request, $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) {
        $this->bladeVars["title"] = "Visualizar Derecho";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Derechos", "url" => "/rights"],
            ["label" => "Visualizar Derecho", "active" => true],
        ];
        $this->maintfile = "Right.RightMaint";
        return parent::show($request, $id);
    }

    public function destroy(Request $request, $id) {
        $this->successMessage = 'Derecho eliminado correctamente.';
        $this->errorMessage = 'El Derecho no pudo eliminarse ya que tiene registros asociados.';
        return parent::destroy($id);
    }

    public function export(Request $request, $type) {
        $this->slfile = "Right.RightSL";
        return parent::export($request, $type);
    }

}
