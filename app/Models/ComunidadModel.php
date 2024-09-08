<?php

namespace App\Models;

use CodeIgniter\Model;

class ComunidadModel extends Model
{
    protected $table = 'comunidad';
    protected $primaryKey = 'ID';
    
    protected $allowedFields = [
        'Nombre',
        'Descripcion',
        'Ubicacion',
        'Latitud',
        'Longitud',
        'Fecha_registro'
    ];
    
    protected $useTimestamps = true; // Si usas created_at y updated_at
    protected $createdField  = 'Fecha_registro';
    // Opcional: Puedes definir un campo `updated_at` si necesitas rastrear actualizaciones
    // protected $updatedField  = 'updated_at'; 

    protected $dateFormat    = 'datetime';
    
    // Si no necesitas campos `created_at` y `updated_at`, puedes omitir los siguientes
    // protected $useTimestamps = false; 
    // protected $createdField  = '';
    // protected $updatedField  = '';

    // Si necesitas alguna lógica antes de insertar o actualizar, puedes definirlo aquí
    // protected $beforeInsert = ['someMethod'];
    // protected $beforeUpdate = ['someMethod'];

    // Ejemplo de un método de transformación
    // protected function someMethod(array $data)
    // {
    //     // Transformaciones o lógica antes de insertar/actualizar
    //     return $data;
    // }
}
