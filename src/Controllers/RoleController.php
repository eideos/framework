<?php

namespace Eideos\Framework\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

class RoleController extends AppController
{

    protected $model = "Eideos\Framework\Role";
    protected $url = "roles";
    protected $rules = [
        'name' => 'required|max:255',
        'table.Eideos__Framework__Right.*.id' => 'required|numeric',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->bladeVars["title"] = "Roles";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Roles"],
        ];
        $this->bladeVars["deleteMessage"] = "¿Está seguro que desea eliminar el rol #name ?";
        if (!isset($this->slfile) || empty($this->slfile)) {
            $this->slfile = "Role.RoleSL";
        }
        return parent::index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->bladeVars["title"] = "Nuevo Rol";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Roles", "url" => "/roles"],
            ["label" => "Nuevo Rol", "active" => true],
        ];
        if (!isset($this->maintfile) || empty($this->maintfile)) {
            $this->maintfile = "Role.RoleMaint";
        }
        return parent::create();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        unset($this->rules['password']);
        $this->bladeVars["title"] = "Modificar Rol";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Roles", "url" => "/roles"],
            ["label" => "Modificar Rol", "active" => true],
        ];
        if (!isset($this->maintfile) || empty($this->maintfile)) {
            $this->maintfile = "Role.RoleMaint";
        }
        return parent::edit($request, $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $this->bladeVars["title"] = "Visualizar Rol";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Roles", "url" => "/roles"],
            ["label" => "Visualizar Rol", "active" => true],
        ];
        if (!isset($this->maintfile) || empty($this->maintfile)) {
            $this->maintfile = "Role.RoleMaint";
        }
        return parent::show($request, $id);
    }

    public function destroy(Request $request, $id)
    {
        $this->successMessage = 'Rol eliminado correctamente.';
        $this->errorMessage = 'El Rol no pudo eliminarse ya que tiene registros asociados.';
        return parent::destroy($id);
    }

    public function export(Request $request, $type)
    {
        if (!isset($this->slfile) || empty($this->slfile)) {
            $this->slfile = "Role.RoleSL";
        }
        return parent::export($request, $type);
    }
}
