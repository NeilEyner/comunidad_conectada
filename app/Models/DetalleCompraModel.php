<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleCompraModel extends Model
{
    protected $table = 'detalle_compra';
    protected $primaryKey = ['ID_Compra', 'ID_Producto']; // Llave primaria compuesta
    protected $allowedFields = ['ID_Compra', 'ID_Producto', 'ID_Artesano', 'Cantidad'];
    protected $useTimestamps = false;   

    function verifDetalle($idC, $idP, $idA){
        $db      = \Config\Database::connect();
        return $this->where('ID_Compra',$idC)->where('ID_Producto',$idP)->where('ID_Artesano',$idA)->first();
    }

    public function actualizarDet($idCompra, $idProducto,$idArtesano, $data)
    {
        return $this->db->table($this->table)
                        ->where('ID_Compra', $idCompra)
                        ->where('ID_Producto', $idProducto)
                        ->where('ID_Artesano', $idArtesano)
                        ->update($data); // Actualizar datos
    }
    public function carritoProd($idCliente)
    {

        return $this->select('compra.ID, compra.Total, detalle_compra.*')
            ->join('compra', 'compra.ID = detalle_compra.ID_Compra')
            ->where('compra.ID_Cliente', $idCliente)
            ->where('compra.Estado', 'PENDIENTE')
            ->findAll();
    }
    
}
