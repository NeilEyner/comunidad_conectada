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
}
