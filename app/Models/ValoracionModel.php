<?php

namespace App\Models;

use CodeIgniter\Model;

class ValoracionModel extends Model
{
    protected $table = 'valoracion';
    protected $primaryKey = ['ID_Usuario', 'ID_Producto']; // Llave primaria compuesta
    protected $allowedFields = ['ID_Usuario', 'ID_Producto', 'Puntuacion', 'Comentario', 'Fecha'];
    protected $useTimestamps = false;   
}
