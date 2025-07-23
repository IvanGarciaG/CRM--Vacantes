<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\{
    RoleModel,
    RoleUserModel,
    UserModel
};
use App\Requests\{
    UpdateRequest,
    UpdateRoleRequest,
    UpdateStatusRequest
};
use App\Services\MailService;
use Exception;

class UserController extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $roleUserModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->roleUserModel = new RoleUserModel();
        $this->db = \Config\Database::connect();
    }
    /**
     * Displays the list of all users
     */
    public function index()
    {
        try {
            $usuarios = $this->userModel->findAll();

            return view('users/index', ['usuarios' => $usuarios]);
        } catch (Exception $e) {
            log_message('error', 'Error while listing users | ' . $e->getMessage() . ' | ' . __METHOD__);

            session()->setFlashdata('error', 'Ocurrió un error al mostrar los usuarios. Inténtalo más tarde.');

            return redirect()->back();
        }
    }
    /**
     * create a new user
     * This method is used to display the form for creating a new user.
     */
    public function create()
    {
        try {
            $roles = $this->roleModel->findAll();

            return view('users/create', [
                'roles' => $roles
            ]);
        } catch (Exception $e) {
            log_message('error', 'Error en create() | ' . $e->getMessage());
            session()->setFlashdata('error', 'Ocurrió un error al cargar el formulario.');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created user in storage.
     */
    public function store()
    {
        try {

            $rules = [
                'nombre'        => 'required|string',
                'apellidos'     => 'required|string',
                'sexo'          => 'required|in_list[Masculino,Femenino,Otro]',
                'email'         => 'required|valid_email|is_unique[users.email]',
                'telefono'      => 'required',
                'codigo_postal' => 'required',
                'colonia'       => 'required',
                'delegacion'    => 'required',
                'estado'        => 'required',
            ];

            if (! $this->validate($rules)) {
                log_message('error', 'Errores de validación: ' . json_encode($this->validator->getErrors()));
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }


            $plainPassword = bin2hex(random_bytes(4)); 
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

            $data = $this->request->getPost([
                'nombre',
                'apellidos',
                'sexo',
                'email',
                'telefono'
            ]);
            $data['password'] = $hashedPassword;
            $data['fecha_registro'] = date('Y-m-d H:i:s');
            $data['estatus'] = 'activo';

            $userId = $this->userModel->insert($data, true);

            
            $direccion = [
                'user_id'       => $userId,
                'codigo_postal' => $this->request->getPost('codigo_postal'),
                'colonia'       => $this->request->getPost('colonia'),
                'delegacion'    => $this->request->getPost('delegacion'),
                'estado'        => $this->request->getPost('estado'),
            ];
            $this->db->table('user_addresses')->insert($direccion);

            
            $this->roleUserModel->insert([
                'user_id' => $userId,
                'role_id' => 3 
            ]);
            

            MailService::sendWelcomeEmail($data, $plainPassword);
            
            session()->setFlashdata('success', 'Usuario creado correctamente y correo enviado.');
            return redirect()->to('/users');
        } catch (\Throwable $e) {
            log_message('error', 'Error en store(): ' . $e->getMessage());
            session()->setFlashdata('error', 'Error al crear el usuario. Intenta más tarde.');
            return redirect()->back()->withInput();
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function show($id)
    {
        try {
            $usuario = $this->userModel->find($id);

            if (! $usuario) {
                session()->setFlashdata('error', 'Usuario no encontrado');
                return redirect()->back();
            }

            $rolUser = $this->roleUserModel->where('user_id', $id)->first();
            $rolNombre = null;

            if ($rolUser) {
                $rol = $this->roleModel->find($rolUser['role_id']);
                $rolNombre = $rol['name'] ?? null;
            }

            return view('users/show', [
                'usuario' => $usuario,
                'rol'     => $rolNombre
            ]);
        } catch (Exception $e) {
            log_message('error', 'Error while showing user [' . $id . '] | ' . $e->getMessage() . ' | ' . __METHOD__);
            session()->setFlashdata('error', 'Ocurrió un error al mostrar el usuario. Intenta más tarde.');
            return redirect()->back();
        }
    }

    /**
     * Displays the user data editing form
     */
    public function edit($id)
    {
        try {
            $usuario = $this->userModel->find($id);

            if (! $usuario) {
                session()->setFlashdata('error', 'Usuario no encontrado');
                return redirect()->back();
            }

            if (is_object($usuario)) {
                $usuario = (array) $usuario;
            }

            $direccion = $this->db->table('user_addresses')
                ->where('user_id', $id)
                ->get()
                ->getRowArray();

            $rolUser = $this->roleUserModel->where('user_id', $id)->first();
            $roles   = $this->roleModel->findAll();

            return view('users/edit', [
                'usuario'   => $usuario,
                'direccion' => $direccion,
                'rol_id'    => $rolUser['role_id'] ?? null,
                'roles'     => $roles
            ]);
        } catch (Exception $e) {
            log_message('error', 'Error while editing user [' . $id . '] | ' . $e->getMessage() . ' | ' . __METHOD__);
            session()->setFlashdata('error', 'Ocurrió un error al cargar el formulario de edición.');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        try {
            $usuario = $this->userModel->find($id);

            if (! $usuario) {
                session()->setFlashdata('error', 'Usuario no encontrado');
                return redirect()->back();
            }

            $rules = UpdateRequest::rules($id);

            if (! $this->validate($rules)) {
                session()->setFlashdata('error', 'Hay errores en el formulario');
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = $this->request->getPost(UpdateRequest::only());
            $rolId = $this->request->getPost('rol_id');

            $this->userModel->update($id, $data);

            
            if ($rolId) {
                $existing = $this->roleUserModel->where('user_id', $id)->first();

                if ($existing) {
                    $this->roleUserModel->update($existing['id'], [
                        'role_id' => $rolId
                    ]);
                } else {
                    $this->roleUserModel->insert([
                        'user_id' => $id,
                        'role_id' => $rolId
                    ]);
                }
            }

            session()->setFlashdata('success', 'Usuario actualizado correctamente');
            return redirect()->to('/users/show/' . $id);
        } catch (Exception $e) {
            log_message('error', 'Error al actualizar usuario [' . $id . '] | ' . $e->getMessage() . ' | ' . __METHOD__);
            session()->setFlashdata('error', 'Ocurrió un error al actualizar el usuario. Intenta más tarde.');
            return redirect()->back();
        }
    }

    /**
     * Update the roles of a user
     */
    public function updateRole($id)
    {
        try {
            $usuario = $this->userModel->find($id);
            if (! $usuario) {
                session()->setFlashdata('error', 'Usuario no encontrado');
                return redirect()->back();
            }

            $rules = UpdateRoleRequest::rules();

            if (! $this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $this->roleUserModel->where('user_id', $id)->delete();

            $roles = $this->request->getPost('role_list');
            foreach ($roles as $roleId) {
                $this->roleUserModel->insert([
                    'user_id' => $id,
                    'role_id' => $roleId
                ]);
            }

            session()->setFlashdata('success', 'Roles actualizados correctamente');
            return redirect()->to('/users/show/' . $id);
        } catch (Exception $e) {
            log_message('error', 'Error al actualizar roles del usuario [' . $id . '] | ' . $e->getMessage() . ' | ' . __METHOD__);
            session()->setFlashdata('error', 'Error al actualizar roles, intenta más tarde.');
            return redirect()->back();
        }
    }

    /**
     * Update the status of a user
     */
    public function updateStatus($id)
    {
        try {
            $usuario = $this->userModel->find($id);
            if (! $usuario) {
                session()->setFlashdata('error', 'Usuario no encontrado');
                return redirect()->back();
            }

            $rules = UpdateStatusRequest::rules();

            if (! $this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $nuevoStatus = $this->request->getPost('status');

            $this->userModel->update($id, ['estatus' => $nuevoStatus]);

            session()->setFlashdata('success', 'Estatus actualizado a: ' . $nuevoStatus);
            return redirect()->to('/users/show/' . $id);
        } catch (\Throwable $e) {
            log_message('error', 'Error al actualizar estatus del usuario [' . $id . '] | ' . $e->getMessage() . ' | ' . __METHOD__);
            session()->setFlashdata('error', 'Ocurrió un error al actualizar el estatus.');
            return redirect()->back();
        }
    }
    /**
     * Delete a user
     */
    public function destroy($id)
    {
        try {
            $usuario = $this->userModel->find($id);

            if (! $usuario) {
                session()->setFlashdata('error', 'Usuario no encontrado');
                return redirect()->back();
            }
            if ($usuario['estatus'] === 'inactivo') {
                session()->setFlashdata('info', 'El usuario ya está inactivo.');
                return redirect()->back();
            }

            $this->userModel->update($id, ['estatus' => 'inactivo']);

            session()->setFlashdata('success', 'Usuario desactivado correctamente.');
            return redirect()->to('/users');
        } catch (\Throwable $e) {
            log_message('error', 'Error al desactivar usuario [' . $id . '] | ' . $e->getMessage() . ' | ' . __METHOD__);
            session()->setFlashdata('error', 'Error al desactivar el usuario. Intenta más tarde.');
            return redirect()->back();
        }
    }
}
