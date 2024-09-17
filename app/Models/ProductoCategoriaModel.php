<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoCategoriaModel extends Model
{
    protected $table = 'producto_categoria';
    protected $primaryKey = ['ID_Producto', 'ID_Categoria']; // Llave primaria compuesta
    protected $allowedFields = ['ID_Producto', 'ID_Categoria'];
    protected $useTimestamps = false;   
}
