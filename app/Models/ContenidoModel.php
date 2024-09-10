<?php

namespace App\Models;

use CodeIgniter\Model;

class ContenidoModel extends Model
{
    protected $table      = 'contenido_pagina';
    protected $primaryKey = 'ID';

    // protected $useAutoIncrement = true;

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['ID', 'Tipo_contenido', 'Titulo', 'Contenido', 'ID_Usuario'];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'Fecha_creacion';
    protected $updatedField  = 'Fecha_actualizacion';
    protected $deletedField  = 'deleted_at';
}
?>