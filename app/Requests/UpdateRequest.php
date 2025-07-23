<?php

namespace App\Requests;

class UpdateRequest
{
    /**
     * Reglas para actualizar usuario
     */
    public static function rules(int $userId): array
    {
        return [
            'nombre'        => 'required|string|max_length[50]',
            'apellidos'     => 'required|string|max_length[50]',
            'sexo'          => 'required|in_list[Masculino,Femenino,Otro]',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
            'telefono'      => 'required|numeric|max_length[15]',
            'codigo_postal' => 'required|string|max_length[10]',
            'colonia'       => 'required|string|max_length[100]',
            'delegacion'     => 'required|string|max_length[100]',
            'estado'        => 'required|string|max_length[100]',
            'rol_id'        => 'permit_empty|is_not_unique[roles.id]'
        ];
    }

    /**
     * Campos que se pueden actualizar
     */
    public static function only(): array
    {
        return [
            'nombre',
            'apellidos',
            'sexo',
            'email',
            'telefono',
            'codigo_postal',
            'colonia',
            'delegacion',
            'estado'
        ];
    }
}