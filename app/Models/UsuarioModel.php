<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'ID';
    
    protected $allowedFields = [
        'Nombre',
        'Correo_electronico',
        'Telefono',
        'Contrasena',
        'ID_Rol',
        'Direccion',
        'Fecha_registro',
        'Estado',
        'Ultima_conexion',
        'ID_Comunidad',
        'Imagen_URL',
        'Latitud',
        'Longitud'
    ];
    
    protected $useTimestamps = true; // Si usas created_at y updated_at
    protected $createdField  = 'Fecha_registro';
    protected $updatedField  = 'Ultima_conexion';
    protected $dateFormat    = 'datetime';

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['Contrasena'])) {
            $data['data']['Contrasena'] = password_hash($data['data']['Contrasena'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}