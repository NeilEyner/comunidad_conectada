<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['Nombre', 'Descripcion'];
    protected $useTimestamps = true; // Cambia a true si usas timestamps automáticos
}
