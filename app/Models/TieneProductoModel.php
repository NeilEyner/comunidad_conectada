<?php

namespace App\Models;

use CodeIgniter\Model;

class TieneProductoModel extends Model
{
    protected $table = 'tiene_producto';
    protected $primaryKey = ['ID_Artesano', 'ID_Producto'];
    protected $allowedFields = ['ID_Artesano', 'ID_Producto', 'Precio', 'Stock', 'Disponibilidad', 'Imagen_URL'];
    protected $useTimestamps = false;

    // Método opcional para obtener productos con detalles de la tabla producto
    public function getProductosConDetalles($idArtesano)
    {
        return $this->select('producto.Nombre as Nombre, producto.Descripcion, tiene_producto.*')
            ->join('producto', 'producto.ID = tiene_producto.ID_Producto')
            ->where('tiene_producto.ID_Artesano', $idArtesano)
            ->findAll();
    }

    public function getProducto($idArtesano, $idProducto)
    {
        return $this->where('ID_Artesano', $idArtesano)
            ->where('ID_Producto', $idProducto)
            ->first();
    }

    function prodRelacionados($id){
        $db      = \Config\Database::connect();
        // return $this->join('producto_categoria', 'producto_categoria.ID_Producto = tiene_producto.ID_Producto')
        //     // ->whereIn($db->table('producto_categoria')->from('producto_categoria')->select('ID_Categoria')
        //     ->whereIn('producto_categoria.ID_Categoria', $db->table('producto_categoria')->select('ID_Categoria')->where('ID_Producto', $id))
        //     ->findAll();
        return $this->distinct()-> select('tiene_producto.ID_Artesano, tiene_producto.ID_Producto,tiene_producto.Precio,tiene_producto.Stock,tiene_producto.Imagen_URL')
            ->join('producto_categoria', 'producto_categoria.ID_Producto = tiene_producto.ID_Producto')
            ->whereIn('producto_categoria.ID_Categoria', $db->table('producto_categoria')
                                                           ->select('ID_Categoria')
                                                           ->where('ID_Producto', $id))
            ->findAll();
    }
}

