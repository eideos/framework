<?php

namespace Eideos\Framework\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

class ButtonController extends AppController {

    protected $model = "Eideos\Framework\Button";
    protected $url = "buttons";
    protected $rules = [
        'name' => 'required|max:100',
        'order' => 'required|max:100',
        'icon' => 'required|max:100',
        'controller' => 'required|max:100',
        'action' => 'required|max:100',
        'refresh' => 'required|in:1,0',
        'active' => 'required|in:1,0',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $this->bladeVars["title"] = "Botones";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Botones"],
        ];
        $this->slfile = "Button.ButtonSL";
        return parent::index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->bladeVars["title"] = "Nuevo Botón";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Botones", "url" => "/buttons"],
            ["label" => "Nuevo Botón", "active" => true],
        ];
        $this->maintfile = "Button.ButtonMaint";
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
        $this->bladeVars["title"] = "Modificar Botón";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Botones", "url" => "/buttons"],
            ["label" => "Modificar Botón", "active" => true],
        ];
        $this->maintfile = "Button.ButtonMaint";
        return parent::edit($request, $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) {
        $this->bladeVars["title"] = "Visualizar Botón";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Botones", "url" => "/buttons"],
            ["label" => "Visualizar Botón", "active" => true],
        ];
        $this->maintfile = "Button.ButtonMaint";
        return parent::show($request, $id);
    }

    public function destroy(Request $request, $id) {
        $this->successMessage = 'Boton eliminado correctamente.';
        $this->errorMessage = 'El Boton no pudo eliminarse ya que tiene registros asociados.';
        return parent::destroy($id);
    }

    public function export(Request $request, $type) {
        $this->slfile = "Button.ButtonSL";
        return parent::export($request, $type);
    }

}
