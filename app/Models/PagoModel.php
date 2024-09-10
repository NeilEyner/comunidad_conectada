<?php

namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model
{
    protected $table = 'pago';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['Fecha', 'Metodo_pago', 'Estado', 'ID_Cliente', 'ID_Compra'];
    protected $useTimestamps = true;
}
