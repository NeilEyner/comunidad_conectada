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
use App\Models\ContenidoModel;
use App\Models\DetalleCompraModel;


class DeliveryController extends Controller
{
    public function delivery()
    {
        if (session()->get('ID_Rol') != 3) {
            return redirect()->to(base_url('login'));
        }


        $db = \Config\Database::connect();

        // Consulta principal de envíos pendientes
        $query = $db->query("
            SELECT e.ID_Compra, t.Tipo, com.Nombre as Comunidad, 
                   e.Direccion_Destino, e.Costo_envio 
            FROM envio e
            JOIN compra c ON c.ID = e.ID_Compra
            JOIN transporte t ON t.ID = e.ID_Transporte
            JOIN comunidad com ON e.Comunidad_Destino = com.ID
            WHERE e.ID_Delivery IS NULL
        ");
        $envios = $query->getResultArray();

        // Obtener detalles de productos para cada compra
        foreach ($envios as &$envio) {
            $query = $db->query("
                SELECT d.ID_Compra, p.Nombre as Producto, t.Imagen_URL, 
                       d.Cantidad, c.Nombre as Comunidad_Artesano
                FROM tiene_producto t
                JOIN detalle_compra d ON d.ID_Producto = t.ID_Producto
                JOIN producto p ON p.ID = t.ID_Producto
                JOIN usuario u ON u.ID = t.ID_Artesano
                JOIN comunidad c ON u.ID_Comunidad = c.ID
                WHERE d.ID_Compra = ?
            ", [$envio['ID_Compra']]);
            $envio['productos'] = $query->getResultArray();
        }
        // Obtener productos y contenido
        $tieneProductoModel = new TieneProductoModel();
        $data['productos'] = $tieneProductoModel->findAll();

        $contenidoModel = new ContenidoModel();
        $data['contenido'] = $contenidoModel->findAll();

        $detalleCompraModel = new DetalleCompraModel();
        $carrito = (session()->get('ID_Rol') == null) ? '' : $detalleCompraModel->carritoProd(session()->get('ID'));

        $data['carrito'] = $carrito;
        return view('global/header', ['titulo' => 'Cliente Dashboard'] + $data)
            . view('dashboard/delivery/dely_dashboard', ['envios' => $envios])
            . view('global/footer', $data);
        // return view('dashboard/delivery/dely_dashboard', ['envios' => $envios]);
    }
    public function envio()
    {
        if (session()->get('ID_Rol') != 3) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $idCompra = session()->get('ID');
        $idCompra = intval($idCompra);

        $query = $db->query("
    SELECT e.ID_Compra,e.Estado,c.Estado as Cestado, t.Tipo, com.Nombre as Comunidad, 
           e.Direccion_Destino, e.Costo_envio 
    FROM envio e
    JOIN compra c ON c.ID = e.ID_Compra
    JOIN transporte t ON t.ID = e.ID_Transporte
    JOIN comunidad com ON e.Comunidad_Destino = com.ID
    WHERE e.ID_Delivery = $idCompra");

        $envios = $query->getResultArray();

        // Obtener detalles de productos para cada compra
        foreach ($envios as &$envio) {
            $query = $db->query("
                SELECT d.ID_Compra, p.Nombre as Producto, t.Imagen_URL, 
                       d.Cantidad, c.Nombre as Comunidad_Artesano
                FROM tiene_producto t
                JOIN detalle_compra d ON d.ID_Producto = t.ID_Producto
                JOIN producto p ON p.ID = t.ID_Producto
                JOIN usuario u ON u.ID = t.ID_Artesano
                JOIN comunidad c ON u.ID_Comunidad = c.ID
                WHERE d.ID_Compra = ?
            ", [$envio['ID_Compra']]);
            $envio['productos'] = $query->getResultArray();
        }
        // Obtener productos y contenido
        $tieneProductoModel = new TieneProductoModel();
        $data['productos'] = $tieneProductoModel->findAll();

        $contenidoModel = new ContenidoModel();
        $data['contenido'] = $contenidoModel->findAll();

        $detalleCompraModel = new DetalleCompraModel();
        $carrito = (session()->get('ID_Rol') == null) ? '' : $detalleCompraModel->carritoProd(session()->get('ID'));

        $data['carrito'] = $carrito;
        return view('global/header', ['titulo' => 'Cliente Dashboard'] + $data)
            . view('dashboard/delivery/envio', ['envios' => $envios])
            . view('global/footer', $data);

        // return view('dashboard/delivery/envio', ['envios' => $envios]);
    }


    public function entregado()
    {

        return view('dashboard/delivery/entregado');
    }

    public function procesar_asignacion()
    {
        $id_compra = $this->request->getPost('id_compra');

        $envioModel = new EnvioModel();
        $data = [
            'ID_Delivery' => session()->get('ID'),
            'Fecha_Envio' => date('Y-m-d'),
            'Estado' => 'EN TRÁNSITO',
        ];
        $resultado = $envioModel->updateEstado($id_compra, $data);
        if ($resultado) {

            session()->setFlashdata('mensaje', 'El envío ha sido asignado correctamente.');
        } else {

            session()->setFlashdata('mensaje', 'Error al asignar el envío. Intenta de nuevo.');
        }
        return redirect()->back();
    }
    public function procesar_entrega()
    {
        $id_compra = $this->request->getPost('id_compra');

        $envioModel = new EnvioModel();
        $data = [
            'Fecha_Entrega' => date('Y-m-d'),
            'Estado' => 'ENTREGADO',
        ];
        $resultado = $envioModel->updateEstado($id_compra, $data);
        if ($resultado) {

            session()->setFlashdata('mensaje', 'El envío ha sido asignado correctamente.');
        } else {

            session()->setFlashdata('mensaje', 'Error al asignar el envío. Intenta de nuevo.');
        }
        return redirect()->back();
    }
}