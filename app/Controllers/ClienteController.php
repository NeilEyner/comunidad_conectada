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
        // Obtener compras del cliente
        $db = \Config\Database::connect();
        $compras = $db->query("SELECT c.Fecha, c.Estado, c.Total, c.ID FROM compra c WHERE c.ID_Cliente = ?", [session()->get('ID')])->getResult();
        $data['compras'] = $compras;
        $detalles = $db->query("SELECT d.ID_Compra, d.Cantidad, p.Nombre FROM detalle_compra d JOIN producto p ON p.ID = d.ID_Producto")->getResult();
        $data['detalles'] = $detalles;

        $envios = $db->query("SELECT e.ID_Compra, t.Tipo, u.Nombre AS Nombre_Delivery, c.Nombre AS Nombre_Comunidad, e.Direccion_Destino, e.Fecha_Envio, e.Fecha_Entrega, e.Estado, e.Costo_envio FROM envio e JOIN usuario u ON u.ID = e.ID_Delivery JOIN transporte t ON t.ID = e.ID_Transporte JOIN comunidad c ON c.ID = e.Comunidad_Destino")->getResult();
        $data['envios'] = $envios;

        return view('dashboard/cliente/cli_dashboard', $data);
    }





    public function procesar_entregado()
    {
        $id_compra = $this->request->getPost('id_compra');
    
        $compraModel = new CompraModel();
    
        // Actualiza el estado de la compra
        $data = [
            'Estado' => 'ENTREGADO',
        ];
    
        // Asegúrate de que el ID de compra no sea nulo
        if ($id_compra) {
            $updated = $compraModel->update($id_compra, $data);
            
            if ($updated) {
                // Mensaje de éxito
                session()->setFlashdata('success', 'La compra ha sido marcada como entregada.');
            } else {
                // Mensaje de error
                session()->setFlashdata('error', 'No se pudo actualizar la compra.');
            }
        } else {
            session()->setFlashdata('error', 'ID de compra no válido.');
        }
    
        return redirect()->back();
    }
    

    public function procesar_cancelado()
    {
        $id_compra = $this->request->getPost('id_compra');
    
        $compraModel = new CompraModel();
    
        // Actualiza el estado de la compra
        $data = [
            'Estado' => 'CANCELADO',
        ];
    
        // Asegúrate de que el ID de compra no sea nulo
        if ($id_compra) {
            $updated = $compraModel->update($id_compra, $data);
            
            if ($updated) {
                // Mensaje de éxito
                session()->setFlashdata('success', 'La compra ha sido marcada como entregada.');
            } else {
                // Mensaje de error
                session()->setFlashdata('error', 'No se pudo actualizar la compra.');
            }
        } else {
            session()->setFlashdata('error', 'ID de compra no válido.');
        }
    
        return redirect()->back();
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