<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class SettingsController extends BaseController
{
    public function settings()
    {
        $usuarioId = session()->get('usuario')['id'];
        $userModel = new UserModel();
        $usuario = $userModel->find($usuarioId);

        return view('settings/index', ['usuario' => $usuario]);
    }

    public function updateSettings()
    {
        $usuarioId = session()->get('usuario')['id'];

        $rules = [
            'nombre' => 'required',
            'apellidos' => 'required',
            'telefono' => 'required|numeric',
            'sexo' => 'required',
            'password' => 'permit_empty|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'apellidos' => $this->request->getPost('apellidos'),
            'telefono' => $this->request->getPost('telefono'),
            'sexo' => $this->request->getPost('sexo'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $userModel->update($usuarioId, $data);

        return redirect()->back()->with('success', 'Configuración actualizada correctamente.');
    }
}
