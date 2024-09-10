<?php

namespace App\Models;

use CodeIgniter\Model;

class EnvioModel extends Model
{
    protected $table = 'envio';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['ID_Compra', 'ID_Delivery', 'ID_Transporte', 'Comunidad_Origen', 'Direccion_Destino', 'Fecha_Envio', 'Fecha_Entrega', 'Estado', 'Distancia', 'Costo_envio'];
    protected $useTimestamps = true;
}
