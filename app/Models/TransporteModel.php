<?php

namespace App\Models;

use CodeIgniter\Model;

class TransporteModel extends Model
{
    protected $table = 'transporte';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['Tipo', 'Descripcion', 'Costo_por_km', 'Capacidad', 'Estado'];
    protected $useTimestamps = false;   
}
