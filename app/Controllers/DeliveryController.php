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
        

        $db = \Config\Database::connect();
        $query = $db->query("SELECT c.ID, p.Nombre, tp.Imagen_URL, dc.Cantidad, c.Total  
                         FROM compra c 
                         JOIN detalle_compra dc ON dc.ID_Compra = c.ID 
                         JOIN producto p ON p.ID = dc.ID_Producto 
                         JOIN tiene_producto tp ON p.ID = tp.ID_Producto 
                         WHERE c.Estado = 'PENDIENTE' AND dc.ID_Artesano = tp.ID_Artesano");

        $data['compras'] = $query->getResult();

        return view('dashboard/delivery/dely_dashboard', $data);
    }
    public function envio()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT c.ID, p.Nombre, tp.Imagen_URL, dc.Cantidad, c.Total  
                         FROM compra c 
                         JOIN detalle_compra dc ON dc.ID_Compra = c.ID 
                         JOIN producto p ON p.ID = dc.ID_Producto 
                         JOIN tiene_producto tp ON p.ID = tp.ID_Producto 
                         WHERE c.Estado = 'PENDIENTE' AND dc.ID_Artesano = tp.ID_Artesano");

        $data['compras'] = $query->getResult();

        return view('dashboard/delivery/envio', $data);
    }

    public function entregado()
    {

        return view('dashboard/delivery/entregado');
    }

}