<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleUserModel;
use App\Models\RoleModel;
use App\Models\UserAddressModel;
use CodeIgniter\I18n\Time;

class AuthController extends BaseController
{
    protected $userModel;
    protected $roleUserModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleUserModel = new RoleUserModel();
    }

    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuario = $this->userModel->where('email', $email)->first();

        if (! $usuario || ! password_verify($password, $usuario['password'])) {
            return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas.');
        }

        session()->set('usuario', [
            'id'      => $usuario['id'],
            'nombre'  => $usuario['nombre'],
            'email'   => $usuario['email'],
            'rol_id'  => $this->roleUserModel->where('user_id', $usuario['id'])->first()['role_id'] ?? null,
        ]);

        return redirect()->to('/dashboard');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function doRegister()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nombre'    => 'required|string|max_length[50]',
            'apellidos' => 'required|string|max_length[50]',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'telefono'  => 'required|numeric|max_length[15]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $password = bin2hex(random_bytes(4)); 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'nombre'         => $this->request->getPost('nombre'),
            'apellidos'      => $this->request->getPost('apellidos'),
            'email'          => $this->request->getPost('email'),
            'telefono'       => $this->request->getPost('telefono'),
            'sexo'           => $this->request->getPost('sexo'),
            'password'       => $hashedPassword,
            'estatus'        => 'activo',
            'fecha_registro' => Time::now(),
        ];

        try {
            $this->userModel->insert($data);
            $userId = $this->userModel->insertID();

            
            $this->roleUserModel->insert([
                'user_id' => $userId,
                'role_id' => 3 
            ]);

            
            $emailService = \Config\Services::email();
            $emailService->setTo($data['email']);
            $emailService->setSubject('Tu nueva cuenta');
            $emailService->setMessage(view('emails/email', [
                'nombre'   => $data['nombre'],
                'password' => $password,
            ]));
            $emailService->setMailType('html');


            if (! $emailService->send()) {
                log_message('error', 'No se pudo enviar correo a ' . $data['email']);
            }

            session()->setFlashdata('correo_enviado', true);
            return redirect()->to('/login');
        } catch (\Throwable $e) {
            log_message('error', 'Error en registro: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al registrar usuario.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
