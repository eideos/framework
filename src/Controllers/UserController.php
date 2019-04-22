<?php

namespace Eideos\Framework\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

class UserController extends AppController
{
    protected $model = "Eideos\Framework\User";
    protected $url = "users";
    protected $rules = [
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,[ID]',
        'active' => 'required|in:1,0',
        'password' => 'required|string|min:6|confirmed',
        'password_confirmation' => 'same:password',
        'table.Eideos__Framework__Role.*.id' => 'required|numeric',
  ];

    public function index(Request $request)
    {
        $this->bladeVars["title"] = "Usuarios";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Usuarios"],
        ];
        if (empty($this->slfile)) {
            $this->slfile = "User.UserSL";
        }
        return parent::index($request);
    }

    public function create()
    {
        $this->bladeVars["title"] = "Nuevo Usuario";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Usuarios", "url" => "/users"],
            ["label" => "Nuevo Usuario", "active" => true],
        ];
        $this->maintfile = "User.UserMaint";
        return parent::create();
    }

    public function show(Request $request, $id)
    {
        $this->bladeVars["title"] = "Visualizar Usuario";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Administración"],
            ["label" => "Administración del Sistema"],
            ["label" => "Usuarios", "url" => "/users"],
            ["label" => "Visualizar Usuario", "active" => true],
        ];
        $this->maintfile = "User.UserMaint";
        return parent::show($request, $id);
    }

    public function edit(Request $request, $id)
    {
        unset($this->rules['password']);
        if (empty($this->bladeVars["title"])) {
            $this->bladeVars["title"] = "Modificar Usuario";
        }
        if (empty($this->bladeVars["breadcrumb"])) {
            $this->bladeVars["breadcrumb"] = [
              ["label" => "Administración"],
              ["label" => "Administración del Sistema"],
              ["label" => "Usuarios", "url" => "/users"],
              ["label" => "Modificar Usuario", "active" => true],
          ];
        }
        if (empty($this->maintfile)) {
            $this->maintfile = "User.UserMaint";
        }
        return parent::edit($request, $id);
    }

    public function edit_personal_data(Request $request)
    {
        $id = \Auth::id();
        unset($this->rules['active']);
        $this->bladeVars["title"] = "Modificar Usuario";
        $this->bladeVars["breadcrumb"] = [
            ["label" => "Información Personal"],
        ];
        $this->url = "home";
        $this->maintfile = "User.UserPersonalMaint";
        return parent::edit($request, $id);
    }

    public function update(Request $request, $id)
    {
        unset($this->rules['password']);
        if (!$request->filled('password') || !$request->filled('password_confirmation')) {
            $request->request->remove('password');
            $request->request->remove('password_confirmation');
        }
        return parent::update($request, $id);
    }

    public function destroy(Request $request, $id)
    {
        $this->successMessage = 'Usuario eliminado correctamente.';
        $this->errorMessage = 'El Usuario no pudo eliminarse ya que tiene registros asociados.';
        return parent::destroy($id);
    }

    public function export(Request $request, $type)
    {
        $this->slfile = "User.UserSL";
        return parent::export($request, $type);
    }
}
