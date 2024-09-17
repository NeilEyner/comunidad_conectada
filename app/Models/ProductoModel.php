<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['Nombre', 'Descripcion', 'Fecha_creacion', 'Fecha_actualizacion'];
    protected $useTimestamps = false;   
}
