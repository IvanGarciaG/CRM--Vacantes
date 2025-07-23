<?php

namespace App\Requests;

use App\Models\RoleModel;

class UpdateRoleRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public static function authorize(array $usuario): bool
    {
        // Simulate that only the admin can change roles

        return isset($usuario['id']) && $usuario['rol'] === RoleModel::ADMIN;
    }

    /**
     * Rules for updating roles (one or multiple)
     */
    public static function rules(): array
    {
        return [
            'role_list'     => 'required|array',
            'role_list.*'   => 'required|integer|is_not_unique[roles.id]'
        ];
    }

    /**
     * Get the valid fields from the request
     */
    public static function only(): array
    {
        return ['role_list'];
    }
}
