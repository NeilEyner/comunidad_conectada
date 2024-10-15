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
}

