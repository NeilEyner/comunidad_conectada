<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuarioModel;
use App\Models\ComunidadModel;
use App\Models\rolModel;
use App\Models\ContenidoPaginaModel;
use App\Models\EnvioModel;
use App\Models\PagoModel;
use App\Models\ProductoModel;
use App\Models\CompraModel;
use App\Models\TieneProductoModel;
use App\Models\CategoriaModel;

class ClienteController extends Controller
{
    public function cliente()
    {
        if (session()->get('ID_Rol') != 2) {
            return redirect()->to(base_url('login'));
        }
        $tieneProductoModel = new TieneProductoModel();
        $productoModel = new ProductoModel();
        $categoriaModel = new CategoriaModel();
    
        $data['productos_list'] = $productoModel->findAll();
        $data['categorias'] = $categoriaModel->findAll();

        return view('dashboard/cliente/cli_dashboard', $data);
    }

    public function compra()
    {
        
        return view('dashboard/cliente/compra');
    }

    public function recibido()
    {
        
        return view('dashboard/cliente/recibido');
    }
    
}