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

    public function puntaje($idP,$idA){
        $db      = \Config\Database::connect();
        $query = $db->query("SELECT SUM(Puntuacion)as Puntaje, count(ID_artesano) as Num FROM valoracion WHERE ID_Producto=$idP and ID_Artesano=$idA");
        $puntos   = $query->getRow();
        return $puntos;
    }
}

