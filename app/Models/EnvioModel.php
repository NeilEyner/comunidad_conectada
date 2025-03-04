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
    public function getEnviosConDetallesPorCliente($clienteId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('envio e');
        $builder->select('e.ID, c.ID AS IdCompra, u.Nombre AS NombreDelivery, c.Estado, co.Nombre AS ComunidaDestino, c.Fecha AS FechaCompra, e.Estado, e.Costo_envio, e.Direccion_Destino, e.Fecha_Envio, e.Fecha_Entrega, t.Tipo AS NombreTransporte');
        $builder->join('compra c', 'c.ID = e.ID_Compra', 'left');
        $builder->join('comunidad co', 'co.ID = e.Comunidad_Destino', 'left');
        $builder->join('transporte t', 't.ID = e.ID_Transporte', 'left');
        $builder->join('usuario u', 'u.ID = e.ID_Delivery', 'left');
        $builder->where('c.ID_Cliente', $clienteId);
        $query = $builder->get();
        return $query->getResultArray(); 
    }
    public function getDetalleEnvioByDelivery($idDelivery)
    {
        return $this->db->table('envio e')
                        ->select('e.ID,e.ID_Compra, co.Nombre, e.Direccion_Destino, e.Estado, e.Costo_envio, e.Latitud, e.Longitud')
                        ->join('compra c', 'c.ID = e.ID_Compra')
                        ->join('comunidad co', 'co.ID = e.Comunidad_Destino')
                        ->where('e.ID_Delivery', $idDelivery)
                        ->get()->getResultArray();
    }
    
}
