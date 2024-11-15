<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\RESTful\ResourceController;

class UsuarioController extends ResourceController
{
    protected $modelName = 'App\Models\UsuarioModel';
    protected $format = 'json';

    // Método para listar usuarios
    public function listarUsuarios()
    {
        $usuarios = $this->model->findAll();
        return $this->respond($usuarios);
    }
}
