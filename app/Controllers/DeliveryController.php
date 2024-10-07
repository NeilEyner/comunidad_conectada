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

class DeliveryController extends Controller
{
    public function delivery()
    {
        if (session()->get('ID_Rol') != 3) {
            return redirect()->to(base_url('login'));
        }
        $tieneProductoModel = new TieneProductoModel();
        $productoModel = new ProductoModel();
        $categoriaModel = new CategoriaModel();
    
        $data['productos_list'] = $productoModel->findAll();
        $data['categorias'] = $categoriaModel->findAll();

        return view('dashboard/delivery/dely_dashboard', $data);
    }
    public function envio()
    {
        
        return view('dashboard/delivery/envio');
    }

    public function entregado()
    {
        
        return view('dashboard/delivery/entregado');
    }
    
}