<?php

namespace App\Models;

use CodeIgniter\Model;

class ComunidadModel extends Model
{
    protected $table = 'comunidad';          // Nombre de la tabla en la base de datos
    protected $primaryKey = 'ID';            // Llave primaria de la tabla
    
    // Campos que se permiten insertar o actualizar mediante el modelo
    protected $allowedFields = [
        'Nombre',
        'Descripcion',
        'Ubicacion',
        'Latitud',
        'Longitud',
        'Fecha_registro'
    ];
    
    // Habilita los timestamps automáticos para created_at y updated_at
    protected $useTimestamps = false;          // Activar timestamps para created_at
    protected $createdField  = 'Fecha_registro'; // Campo para la fecha de creación
    protected $updatedField  = null;           // Desactiva el campo de actualización
    protected $dateFormat    = 'datetime';    // Formato de las fechas
}
