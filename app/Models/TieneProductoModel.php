<?php

namespace App\Models;

use CodeIgniter\Model;

class TieneProductoModel extends Model
{
    protected $table = 'tiene_producto';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['ID_Artesano', 'ID_Producto', 'Precio', 'Stock', 'Disponibilidad', 'Imagen_URL', 'Descripcion', 'Fecha_Creacion'];
    protected $useTimestamps = false;

    public function getProductoByTieneProductoId($tieneProductoId)
    {
        return $this->db->table('tiene_producto')
            ->join('producto', 'tiene_producto.ID_Producto = producto.ID')
            ->where('tiene_producto.ID', $tieneProductoId)
            ->get()
            ->getRowArray();
    }
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

    public function getProductoID($id)
    {
        return $this->where('ID', $id)
            ->first();
    }

    function prodRelacionados($id)
    {
        $db = \Config\Database::connect();

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

    public function getProductosConValoraciones($idArtesano)
    {
        // Realizamos la consulta personalizada
        $query = $this->db->query("
            SELECT 
                tp.ID AS ProductoID,
                tp.ID_Artesano,
                p.Nombre AS ProductoNombre,
                tp.Descripcion AS ProductoDescripcion,
                tp.Imagen_URL,
                tp.Precio,
                tp.Stock,
                tp.Disponibilidad,
                tp.Fecha_Creacion AS FechaCreacionProducto,
                v.Puntuacion,
                v.Comentario AS ValoracionComentario,
                v.Fecha AS FechaValoracion
            FROM 
                tiene_producto tp
            JOIN 
                producto p ON p.ID = tp.ID_Producto
            JOIN 
                valoracion v ON v.ID_Producto = tp.ID
            WHERE 
                tp.ID_Artesano = ?
            ORDER BY 
                v.Fecha DESC
        ", [$idArtesano]);

        // Devolvemos los resultados en forma de array
        return $query->getResultArray();
    }
    //NUEVA TIENDA
    public function getProductosTienda()
    {
        // Construimos la consulta
        $builder = $this->db->table('tiene_producto tp');
        $builder->select('tp.ID AS ID, p.ID AS ProductoID, tp.Imagen_URL, p.Nombre AS ProductoNombre, tp.Precio, tp.Stock, tp.Descripcion, 
                    u.Nombre AS ArtesanoNombre, c.Nombre AS ArtesanoComunidad, 
                    IFNULL(ROUND(AVG(v.Puntuacion), 2), 0) AS PuntuacionPromedio, 
                    GROUP_CONCAT(DISTINCT cat.Nombre ORDER BY cat.Nombre ASC) AS Categorias');
        $builder->join('producto p', 'tp.ID_Producto = p.ID');
        $builder->join('usuario u', 'u.ID = tp.ID_Artesano');
        $builder->join('comunidad c', 'c.ID = u.ID_Comunidad');
        $builder->join('valoracion v', 'v.ID_Producto = tp.ID', 'left');
        $builder->join('producto_categoria pc', 'pc.ID_Producto = p.ID', 'left');
        $builder->join('categoria cat', 'cat.ID = pc.ID_Categoria', 'left');
        $builder->where('tp.Stock >', 0);  // Filtramos productos con stock disponible
        $builder->groupBy('tp.ID, tp.Imagen_URL, p.Nombre, tp.Precio, tp.Stock, tp.Descripcion, u.Nombre, c.Nombre');
        $builder->orderBy('tp.Fecha_Creacion', 'ASC');  // Ordenamos por la fecha de creación

        // Ejecutamos la consulta y devolvemos los resultados
        return $builder->get()->getResultArray();  // Devolvemos los resultados como un array
    }

}

