<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleCompraModel extends Model
{
    protected $table = 'detalle_compra';
    protected $primaryKey = ['ID_Compra', 'ID_Producto']; // Llave primaria compuesta
    protected $allowedFields = ['ID_Compra', 'ID_Producto', 'ID_Artesano', 'Cantidad'];
    protected $useTimestamps = false;

    function verifDetalle($idC, $idP, $idA)
    {
        $db = \Config\Database::connect();
        return $this->where('ID_Compra', $idC)->where('ID_Producto', $idP)->where('ID_Artesano', $idA)->first();
    }

    public function actualizarDet($idCompra, $idProducto, $idArtesano, $data)
    {
        return $this->db->table($this->table)
            ->where('ID_Compra', $idCompra)
            ->where('ID_Producto', $idProducto)
            ->where('ID_Artesano', $idArtesano)
            ->update($data); // Actualizar datos
    }
    public function carritoProd($idCliente)
    {

        return $this->select('compra.ID, compra.Total, detalle_compra.*,tiene_producto.*,producto.Nombre')
            ->join('compra', 'compra.ID = detalle_compra.ID_Compra')
            ->join('tiene_producto', 'tiene_producto.ID_Producto = detalle_compra.ID_Producto and tiene_producto.ID_Artesano =detalle_compra.ID_Artesano')
            ->join('producto', 'producto.ID = detalle_compra.ID_Producto')

            ->where('compra.ID_Cliente', $idCliente)
            // ->where('tiene_producto.ID_Artesano', 'detalle_compra.ID_Artesano')
            ->where('compra.Estado', 'PENDIENTE')
            ->findAll();
    }
    public function carritoUnProd($idCliente, $idArtesano, $idProducto)
    {

        return $this->select('compra.ID, compra.Total, detalle_compra.*,tiene_producto.*,producto.Nombre')
            ->join('compra', 'compra.ID = detalle_compra.ID_Compra')
            ->join('tiene_producto', 'tiene_producto.ID_Producto = detalle_compra.ID_Producto and tiene_producto.ID_Artesano =detalle_compra.ID_Artesano')
            ->join('producto', 'producto.ID = detalle_compra.ID_Producto')
            ->where('compra.ID_Cliente', $idCliente)
            ->where('tiene_producto.ID_Artesano', $idArtesano)
            ->where('tiene_producto.ID_producto', $idProducto)
            // ->where('tiene_producto.ID_Artesano', 'detalle_compra.ID_Artesano')
            ->where('compra.Estado', 'PENDIENTE')
            ->first();
    }

    public function encontrar($idC, $idP, $idA)
    {
        return $this->where('ID_Compra', $idC)
            ->where('ID_Producto', $idP)
            ->where('ID_Artesano', $idA)
            ->first();
    }
    public function eliminar($idC, $idP, $idA)
    {
        return $this->where('ID_Compra', $idC)
            ->where('ID_Producto', $idP)
            ->where('ID_Artesano', $idA)
            ->delete();
    }

    public function obtenerDetallesCompra($idCliente)
    {
        return $this->select('compra.ID, compra.Total, detalle_compra.*, tiene_producto.*, producto.Nombre, comunidad.Latitud, comunidad.Longitud')
            ->join('compra', 'compra.ID = detalle_compra.ID_Compra')
            ->join('tiene_producto', 'tiene_producto.ID_Producto = detalle_compra.ID_Producto and tiene_producto.ID_Artesano = detalle_compra.ID_Artesano')
            ->join('producto', 'producto.ID = detalle_compra.ID_Producto')
            ->join('usuario', 'usuario.ID = detalle_compra.ID_Artesano')  // Unimos la tabla de usuario para obtener la comunidad del artesano
            ->join('comunidad', 'comunidad.ID = usuario.ID_Comunidad')  // Unimos la tabla de comunidad para obtener la latitud y longitud
            ->where('compra.ID_Cliente', $idCliente)
            ->where('compra.Estado', 'PENDIENTE')
            ->findAll();
    }
    public function getProductosVendidosPorArtesano($idArtesano)
    {
        // Fetch all products sold by the artisan with the given ID
        return $this->select('tiene_producto.Imagen_URL, tiene_producto.Descripcion, detalle_compra.Cantidad, tiene_producto.Precio')
            ->join('tiene_producto', 'tiene_producto.ID_Producto = detalle_compra.ID_Producto')
            ->where('tiene_producto.ID_Artesano', $idArtesano)
            ->findAll();
    }
    public function getDetallesByCompra($compraId)
    {
        return $this->asArray()
                    ->select('d.ID_Compra, p.Nombre as Producto, p.ID as ID_Producto, COALESCE(tp.Imagen_URL, "/assets/img/default-product.jpg") as Imagen_URL, d.Cantidad, c.Nombre as Comunidad_Artesano, u.Latitud, u.Longitud, u.Direccion, u.ID as ID_Artesano')
                    ->join('producto p', 'p.ID = d.ID_Producto')
                    ->join('tiene_producto tp', 'tp.ID_Producto = p.ID AND tp.ID_Artesano = d.ID_Artesano', 'left')
                    ->join('usuario u', 'u.ID = d.ID_Artesano')
                    ->join('comunidad c', 'c.ID = u.ID_Comunidad')
                    ->where('d.ID_Compra', $compraId)
                    ->findAll();
    }
    

}
