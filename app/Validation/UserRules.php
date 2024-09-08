<?php namespace App\Validation;

use App\Models\UsuarioModel;

class UserRules
{
    public function validateUser(string $str, string $fields, array $data)
    {
        $model = new UsuarioModel();
        $user = $model->where('Correo_electronico', $data['Correo_electronico'])
                      ->first();

        if (!$user)
            return false;

        return password_verify($data['Contrasena'], $user['Contrasena']);
    }
}
