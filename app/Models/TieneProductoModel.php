<?php

namespace App\Models;

use CodeIgniter\Model;

class TieneProductoModel extends Model
{
    protected $table = 'tiene_producto';
    protected $primaryKey = ['ID_Artesano', 'ID_Producto']; // Llave primaria compuesta
    protected $allowedFields = ['ID_Artesano', 'ID_Producto', 'Precio', 'Stock', 'Disponibilidad', 'Imagen_URL'];
    protected $useTimestamps = true;
}
