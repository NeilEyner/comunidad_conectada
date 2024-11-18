<?php

namespace App\Models;

use CodeIgniter\Model;

class EnvioModel extends Model
{
    protected $table = 'envio';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['ID_Compra', 'ID_Delivery', 'ID_Transporte', 'Comunidad_Destino', 'Direccion_Destino', 'Fecha_Envio', 'Fecha_Entrega', 'Estado', 'Distancia', 'Costo_envio','Latitud','Longitud'];
    protected $useTimestamps = false;   
    public function updateEstado($id_compra, $data)
    {
        return $this->set($data)->where('ID_Compra', $id_compra)->update();
    }
    public function getEnviosByUser($userId)
    {
        return $this->asArray()
                    ->select('ID_Compra, Estado, Fecha_Envio, Fecha_Entrega, ID_Transporte, Comunidad_Destino, Direccion_Destino, Costo_envio, Distancia, Latitud, Longitud')
                    ->join('compra c', 'c.ID = envio.ID_Compra')
                    ->where('envio.ID_Delivery', $userId)
                    ->where('c.Estado !=', 'CANCELADO')
                    ->where('envio.Estado', 'PREPARANDO')
                    ->findAll();
    }
}
