<?php

namespace App\Models;

use CodeIgniter\Model;

class CompraModel extends Model
{
    protected $table = 'compra';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['Fecha', 'Estado', 'ID_Cliente', 'Total'];
    protected $useTimestamps = true;
}
