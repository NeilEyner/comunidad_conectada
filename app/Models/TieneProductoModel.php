<?php

namespace App\Models;

use CodeIgniter\Model;

class TieneProductoModel extends Model
{
    protected $table = 'tiene_producto';
    protected $primaryKey = ['ID_Artesano', 'ID_Producto'];
    protected $allowedFields = ['ID_Artesano', 'ID_Producto', 'Precio', 'Stock', 'Disponibilidad', 'Imagen_URL', 'Descripcion','Fecha_Creacion'];
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
        // Realiza la consulta y guarda el resultado
        $query = $this->select('ANY_VALUE(tiene_producto.Descripcion) AS Descripcion, 
        ANY_VALUE(tiene_producto.Imagen_URL) AS Imagen_URL, 
        ANY_VALUE(tiene_producto.Stock) AS Stock, 
        MAX(valoracion.Puntuacion) AS MejorPuntuacion, 
        AVG(valoracion.Puntuacion) AS PromedioPuntuacion,
        COUNT(valoracion.Puntuacion) AS TotalPuntuaciones')
            ->join('valoracion', 'valoracion.ID_Producto = tiene_producto.ID_Producto')
            ->where('tiene_producto.ID_Artesano', $idArtesano)
            ->where('valoracion.ID_Artesano', $idArtesano)
            ->groupBy('tiene_producto.ID_Producto')
            ->orderBy('MejorPuntuacion', 'DESC')
            ->findAll();


        // Verifica si la consulta ha retornado algún resultado
        if ($query !== false) {
            return $query; // Retorna los resultados si es válido
        } else {
            // Si la consulta falla, puedes manejar el error o retornar un arreglo vacío
            log_message('error', 'La consulta para obtener los productos puntuados falló.');
            return []; // Devuelve un array vacío si no hay resultados
        }
    }



}

