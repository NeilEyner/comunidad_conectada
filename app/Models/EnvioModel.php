<?php

namespace App\Models;

use CodeIgniter\Model;

class EnvioModel extends Model
{
    protected $table = 'envio';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['ID_Compra', 'ID_Delivery', 'ID_Transporte', 'Comunidad_Destino', 'Direccion_Destino', 'Fecha_Envio', 'Fecha_Entrega', 'Estado', 'Distancia', 'Costo_envio'];
    protected $useTimestamps = false;   
    public function updateEstado($id_compra, $data)
    {
        return $this->set($data)->where('ID_Compra', $id_compra)->update();
    }
}
