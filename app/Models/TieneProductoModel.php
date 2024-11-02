<?php

namespace App\Models;

use CodeIgniter\Model;

class TieneProductoModel extends Model
{
    protected $table = 'tiene_producto';
    protected $primaryKey = ['ID_Artesano', 'ID_Producto'];
    protected $allowedFields = ['ID_Artesano', 'ID_Producto', 'Precio', 'Stock', 'Disponibilidad', 'Imagen_URL', 'Descripcion'];
    protected $useTimestamps = false;

    // Método opcional para obtener productos con detalles de la tabla producto
    public function getProductosConDetalles($idArtesano)
    {
        return $this->select('producto.Nombre as Nombre, tiene_producto.*')
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

    function prodRelacionados($id)
    {
        $db = \Config\Database::connect();
        // return $this->join('producto_categoria', 'producto_categoria.ID_Producto = tiene_producto.ID_Producto')
        //     // ->whereIn($db->table('producto_categoria')->from('producto_categoria')->select('ID_Categoria')
        //     ->whereIn('producto_categoria.ID_Categoria', $db->table('producto_categoria')->select('ID_Categoria')->where('ID_Producto', $id))
        //     ->findAll();
        return $this->distinct()->select('tiene_producto.ID_Artesano, tiene_producto.ID_Producto,tiene_producto.Precio,tiene_producto.Stock,tiene_producto.Imagen_URL')
            ->join('producto_categoria', 'producto_categoria.ID_Producto = tiene_producto.ID_Producto')
            ->whereIn('producto_categoria.ID_Categoria', $db->table('producto_categoria')
                ->select('ID_Categoria')
                ->where('ID_Producto', $id))
            ->findAll();
    }

    public function ProductosDet($idArtesano, $idProducto)
    {
        return $this->select('producto.Nombre as Nombre, tiene_producto.*')
            ->join('producto', 'producto.ID = tiene_producto.ID_Producto')
            ->where('tiene_producto.ID_Artesano', $idArtesano)
            ->where('tiene_producto.ID_Producto', $idProducto)
            ->first();
    }

    public function actualizarProd($idArtesano, $idProducto, $data)
    {
        return $this->db->table($this->table)
            ->where('ID_Artesano', $idArtesano)
            ->where('ID_Producto', $idProducto)
            ->update($data);
    }

    public function prodTienda()
    {

        return $this->select('tiene_producto.*, usuario.Nombre,comunidad.Nombre as Comunidad')
            ->join('usuario', 'usuario.ID= tiene_producto.ID_Artesano')
            ->join('comunidad', 'comunidad.ID=usuario.ID_Comunidad')
            ->where('Disponibilidad', '1')->where('Stock>=1')->findAll();
    }

    public function getProductosPuntuadosPorArtesano($idArtesano)
    {
        return $this->select('tiene_producto.Descripcion, tiene_producto.Imagen_URL, tiene_producto.Stock, valoracion.Puntuacion')
            ->join('valoracion', 'valoracion.ID_Producto = tiene_producto.ID_Producto')
            ->where('tiene_producto.ID_Artesano', $idArtesano)
            ->orderBy('valoracion.Puntuacion', 'DESC') // Ordenar por puntuación, de mayor a menor
            ->findAll();
    }
    

}

