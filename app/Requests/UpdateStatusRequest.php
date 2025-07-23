<?php

namespace App\Requests;

use App\Models\RoleModel;
use App\Models\UserModel;

class UpdateStatusRequest
{
    /**
     * Simualte that only the admin can change user status
     * @param array $usuario
     * @return bool
     */
    public static function authorize(array $usuario): bool
    {
        return isset($usuario['id']) && $usuario['rol'] === RoleModel::ADMIN;
    }

    /**
     * Rules for updating user status
     * @return array
     */
    public static function rules(): array
    {
        return [
            'status' => 'required|in_list[activo,inactivo]'
        ];
    }

    /**
     * Fields that are valid to obtain from the request
     */
    public static function only(): array
    {
        return ['status'];
    }
}
