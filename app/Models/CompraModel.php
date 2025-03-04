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

    public function obtenerDetallesCompras($cliente)
    {
        $builder = $this->db->table('compra c');
        $builder->select('c.ID, tp.ID AS ID_Producto ,p.Nombre, tp.Imagen_URL, tp.Precio, dc.Cantidad, c.Total');
        $builder->join('detalle_compra dc', 'c.ID = dc.ID_Compra');
        $builder->join('tiene_producto tp', 'tp.ID = dc.ID_Producto');
        $builder->join('producto p', 'p.ID = tp.ID_Producto');
        $builder->where('c.ID_Cliente', $cliente);
        $builder->where('c.Estado', 'PENDIENTE');
        $query = $builder->get();
        return $query->getResultArray(); 
    }
    public function obtenerDetallesComprasID($compraID)
    {
        $builder = $this->db->table('compra c');
        $builder->select('c.ID, tp.ID AS ID_Producto,p.Nombre, tp.Imagen_URL, tp.Precio, dc.Cantidad, c.Total');
        $builder->join('detalle_compra dc', 'c.ID = dc.ID_Compra');
        $builder->join('tiene_producto tp', 'tp.ID = dc.ID_Producto');
        $builder->join('producto p', 'p.ID = tp.ID_Producto');
        $builder->where('c.ID', $compraID);
        $builder->where('c.Estado', 'PENDIENTE');
        $query = $builder->get();
        return $query->getResultArray(); 
    }

    function getProductosCompraID($idCompra) {
        return $this->db->table('compra c')
            ->select('c.ID as compra_id, tp.ID as producto_id, p.Nombre as producto_nombre, tp.Imagen_URL, tp.Precio, tp.Descripcion,tp.Stock, u.Nombre as artesano_nombre, dc.Cantidad, c.Total')
            ->join('detalle_compra dc', 'dc.ID_Compra = c.ID')
            ->join('tiene_producto tp', 'tp.ID = dc.ID_Producto')
            ->join('usuario u', 'u.ID = tp.ID_Artesano')
            ->join('producto p', 'p.ID = tp.ID_Producto')
            ->where('c.ID', $idCompra)
            ->get()->getResultArray();
    }
    function getProductosCompras() {
        return $this->db->table('compra c')
            ->select('c.ID as compra_id, tp.ID as producto_id, p.Nombre as producto_nombre, tp.Imagen_URL,dc.Estado, tp.Precio, tp.Descripcion,tp.Stock, u.Nombre as artesano_nombre, dc.Cantidad, c.Total')
            ->join('detalle_compra dc', 'dc.ID_Compra = c.ID')
            ->join('tiene_producto tp', 'tp.ID = dc.ID_Producto')
            ->join('usuario u', 'u.ID = tp.ID_Artesano')
            ->join('producto p', 'p.ID = tp.ID_Producto')
            ->get()->getResultArray();
    }
    public function getComprasByUsuario($idUsuario)
    {
        return $this->db->table('compra c')
                    ->select('c.ID, c.Fecha, c.Estado, c.Total, u.Nombre, u.ID_Rol')
                    ->join('usuario u', 'u.ID = c.ID_Cliente')
                    ->where('u.ID', $idUsuario)
                    ->get()->getResultArray();
    }
}

