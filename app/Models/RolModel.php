<?php

namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['Nombre', 'Descripcion'];
}
