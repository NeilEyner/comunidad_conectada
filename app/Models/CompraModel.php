<?php

namespace App\Models;

use CodeIgniter\Model;

class CompraModel extends Model
{
    protected $table = 'compra';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['Fecha', 'Estado', 'ID_Cliente', 'Total'];
    protected $useTimestamps = false;   


    function verifCompra($idC){
        $db      = \Config\Database::connect();
        return $this->where('ID_Cliente',$idC)->where('Estado','PENDIENTE')->first();
    }

    function ActualizarCompra($idC,$data){
        return $this->db->table($this->table)
                        ->where('ID', $idC)
                        ->update($data); // Actualizar datos
    }
    function getProductosCompra($idCompra){
        return $this->db->table('tiene_producto')
        ->select('tiene_producto.*, producto.Nombre, detalle_compra.Cantidad')
        ->join('producto', 'tiene_producto.ID_Producto = producto.ID')
        ->join('detalle_compra', 'detalle_compra.ID_Producto = tiene_producto.ID_Producto')
        ->where('detalle_compra.ID_Compra', $idCompra)
        ->get()->getResultArray();
    
    }
    public function obtenerIDUsuarioDeCompra($idCompra)
    {
        return $this->select('ID_Cliente')  // Seleccionar solo el ID del Usuario
                    ->where('ID', $idCompra)  // Filtrar por el ID de la compra
                    ->first(); // Devuelve el primer resultado (en este caso debería ser único)
    }
}

