<?php

namespace App\Models;

use CodeIgniter\Model;

class ValoracionModel extends Model
{
    protected $table = 'valoracion';
    protected $primaryKey = ['ID_Usuario', 'ID_Producto']; // Llave primaria compuesta
    protected $allowedFields = ['ID_Usuario', 'ID_Producto', 'Puntuacion', 'Comentario', 'Fecha','ID_Artesano'];
    protected $useTimestamps = false;   

    public function verifValoracion($idU, $idP, $idA){
        return $this->where('ID_Usuario',$idU)->where('ID_Producto',$idP)->where('ID_Artesano',$idA)->first();
    }

    public function puntaje($idP, $idA)
    {
        $db = \Config\Database::connect();
        
        // Usando Query Builder con parámetros
        $builder = $db->table('valoracion');
        $builder->select('SUM(Puntuacion) as Puntaje, count(ID_artesano) as Num');
        $builder->where('ID_Producto', $idP);
        $builder->where('ID_Artesano', $idA);
        
        $query = $builder->get();
        $puntos = $query->getRow();
        
        // Verificar si se encontró un resultado
        if ($puntos) {
            return $puntos;
        } else {
            return (object) ['Puntaje' => 0, 'Num' => 0]; // Retornar valores predeterminados si no hay registros
        }
    }
    
}

