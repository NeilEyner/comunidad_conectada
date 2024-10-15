<?php

namespace App\Models;

use CodeIgniter\Model;

class ContenidoPaginaModel extends Model
{
    protected $table = 'contenido_pagina';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['Tipo_contenido', 'Titulo', 'Contenido', 'ID_Usuario', 'Subtitulo', 'Imagen', 'Fecha_creacion', 'Fecha_actualizacion'];
    protected $useTimestamps = false;   
}
