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
use App\Models\TransporteModel;
use App\Models\NotificacionModel;
use App\Models\AuditoriaModel;

class DeliveryController extends Controller
{
    public function delivery()
    {
        // Verificar autenticación
        if (session()->get('ID_Rol') != 3) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $userId = session()->get('ID');

        try {
            // Consulta principal de envíos pendientes con estado
            $query = $db->query("
                SELECT 
                    e.ID_Compra,
                    e.Estado,
                    e.Fecha_Envio,
                    e.Fecha_Entrega, 
                    t.Tipo,
                    com.Nombre as Comunidad,
                    e.Direccion_Destino,
                    e.Costo_envio,
                    e.Distancia,
                    e.Latitud,
                    e.Longitud,
                    c.Estado as Estado_Compra
                FROM envio e
                LEFT JOIN compra c ON c.ID = e.ID_Compra
                LEFT JOIN transporte t ON t.ID = e.ID_Transporte
                LEFT JOIN comunidad com ON e.Comunidad_Destino = com.ID
                JOIN pago p ON p.ID_Compra = c.ID
                WHERE (e.ID_Delivery = ? OR e.ID_Delivery IS NULL)
                AND c.Estado != 'CANCELADO'
                AND e.Estado = 'PREPARANDO'
                AND p.Estado = 'COMPLETADO'
                ORDER BY e.Fecha_Envio DESC
            ", [$userId]);

            if (!$query) {
                throw new \Exception("Error en la consulta principal de envíos: " . $db->error());
            }

            $envios = $query->getResultArray();

            // Obtener detalles de productos para cada compra
            foreach ($envios as &$envio) {
                $productosQuery = $db->query("
                    SELECT 
                        d.ID_Compra,
                        tp.ID as ID_Producto,
                        p.Nombre as Producto,
                        COALESCE(tp.Imagen_URL, '/assets/img/default-product.jpg') as Imagen_URL,
                        d.Cantidad,
                        c.Nombre as Comunidad_Artesano,
                        u.Latitud,
                        u.Longitud,
                        u.Direccion,
                        u.ID as ID_Artesano
                    FROM detalle_compra d
                    JOIN tiene_producto tp ON tp.ID= d.ID_Producto
                    JOIN producto p ON p.ID = tp.ID_Producto
                    JOIN usuario u ON u.ID = d.ID_Artesano
                    JOIN comunidad c ON u.ID_Comunidad = c.ID
                    WHERE d.ID_Compra = ?
                ", [$envio['ID_Compra']]);

                if (!$productosQuery) {
                    throw new \Exception("Error en la consulta de productos para la compra ID: {$envio['ID_Compra']}. " . $db->error());
                }

                $envio['productos'] = $productosQuery->getResultArray();
            }
            $tieneProductoModel = new TieneProductoModel();
            $contenidoModel = new ContenidoModel();
            $detalleCompraModel = new DetalleCompraModel();
            $transportesModel = new TransporteModel();
            $data = [
                'titulo' => 'Dashboard de Delivery',
                'productos' => $tieneProductoModel->findAll(),
                'contenido' => $contenidoModel->findAll(),
                'transportes' => $transportesModel->findAll(),
                'carrito' => (session()->get('ID_Rol') == null) ? '' :
                    $detalleCompraModel->carritoProd(session()->get('ID')),
                'envios' => $envios
            ];
            return
                view('global/header', $data) .
                view('dashboard/delivery/dely_dashboard', ['envios' => $envios]) .
                view('global/footer', $data);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al procesar la solicitud.');
        }
    }

    public function envio()
    {
        if (session()->get('ID_Rol') != 3) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $userId = session()->get('ID');

        try {
            // Consulta principal de envíos pendientes con estado
            $query = $db->query("
                SELECT 
                    e.ID_Compra,
                    e.Estado,
                    e.Fecha_Envio,
                    e.Fecha_Entrega, 
                    t.Tipo,
                    com.Nombre as Comunidad,
                    e.Direccion_Destino,
                    e.Costo_envio,
                    e.Distancia,
                    e.Latitud,
                    e.Longitud,
                    c.Estado as Estado_Compra
                FROM envio e
                LEFT JOIN compra c ON c.ID = e.ID_Compra
                LEFT JOIN transporte t ON t.ID = e.ID_Transporte
                LEFT JOIN comunidad com ON e.Comunidad_Destino = com.ID
                WHERE e.ID_Delivery = ?
                AND c.Estado != 'CANCELADO'
                AND e.Estado != 'PREPARANDO'
                ORDER BY e.Fecha_Envio DESC
            ", [$userId]);

            if (!$query) {
                throw new \Exception("Error en la consulta principal de envíos: " . $db->error());
            }

            $envios = $query->getResultArray();

            // Obtener detalles de productos para cada compra
            foreach ($envios as &$envio) {
                $productosQuery = $db->query("
                   SELECT 
                        d.ID_Compra,
                        tp.ID as ID_Producto,
                        d.Estado as Estado,
                        p.Nombre as Producto,
                        COALESCE(tp.Imagen_URL, '/assets/img/default-product.jpg') as Imagen_URL,
                        d.Cantidad,
                        c.Nombre as Comunidad_Artesano,
                        u.Latitud,
                        u.Longitud,
                        u.Direccion,
                        u.ID as ID_Artesano
                    FROM detalle_compra d
                    JOIN tiene_producto tp ON tp.ID= d.ID_Producto
                    JOIN producto p ON p.ID = tp.ID_Producto
                    JOIN usuario u ON u.ID = d.ID_Artesano
                    JOIN comunidad c ON u.ID_Comunidad = c.ID
                    WHERE d.ID_Compra = ?
                ", [$envio['ID_Compra']]);

                if (!$productosQuery) {
                    throw new \Exception("Error en la consulta de productos para la compra ID: {$envio['ID_Compra']}. " . $db->error());
                }


                $envio['productos'] = $productosQuery->getResultArray();


            }
            $tieneProductoModel = new TieneProductoModel();
            $contenidoModel = new ContenidoModel();
            $detalleCompraModel = new DetalleCompraModel();
            $transportesModel = new TransporteModel();
            $data = [
                'titulo' => 'Dashboard de Delivery',
                'productos' => $tieneProductoModel->findAll(),
                'contenido' => $contenidoModel->findAll(),
                'transportes' => $transportesModel->findAll(),
                'carrito' => (session()->get('ID_Rol') == null) ? '' :
                    $detalleCompraModel->carritoProd(session()->get('ID')),
                'envios' => $envios
            ];
            return
                view('global/header', $data) .
                view('dashboard/delivery/envio', ['envios' => $envios]) .
                view('global/footer', $data);
        } catch (\Exception $e) {
            // Registrar el error completo
            log_message('error', 'Excepción en la función envio: ' . $e->getMessage());
            log_message('error', 'ID: ' . session()->get('ID') . ' | ID_Rol: ' . session()->get('ID_Rol'));


            // Redirigir con mensaje de error
            return redirect()->back()->with('error', 'Ocurrió un error al procesar la solicitud.');
        }

    }
    public function entregado()
    {

        return view('dashboard/delivery/entregado');
    }

    public function procesar_asignacion()
    {
        $usuarioID = session()->get('ID');
        $usuarioNombre = session()->get('Nombre');
        $tipoEvento = 'SISTEMA';
        $location = 'LA PAZ';
        $descripcion = session()->get('Nombre') . "HA ACEPTADO EL ENVIO";
        $auditoriaEventoModel = new AuditoriaModel();
        $auditoriaEventoModel->registrarEvento(
            $tipoEvento,
            $usuarioID,
            $usuarioNombre,
            $this->request->getIPAddress(),
            $this->request->getUserAgent(),
            $location,
            $descripcion
        );


        $id_compra = $this->request->getPost('id_compra');
        $transporte_id = $this->request->getPost('transporte_id');
        $costo_envio = $this->request->getPost('costo_envio');
        if (empty($id_compra) || empty($transporte_id) || empty($costo_envio)) {
            session()->setFlashdata('mensaje', 'Faltan datos necesarios para procesar el envío.');
            return redirect()->back();
        }
        $envioModel = new EnvioModel();
        $data = [
            'ID_Transporte' => $transporte_id,
            'Costo_envio' => $costo_envio,
            'Distancia' => $this->request->getPost('distancia'),
            'ID_Delivery' => session()->get('ID'),
            'Fecha_Envio' => date('Y-m-d'),
            'Estado' => 'EN TRÁNSITO',
        ];
        $compra = new CompraModel();
        $usuarioID = $compra->obtenerIDUsuarioDeCompra($id_compra)['ID_Cliente'];
        $tipo = 'ENVIO';
        $mensaje = "Tu envio se ha sido aceptado.";
        $notificacionModel = new NotificacionModel();
        $notificacionModel->registrarNotificacion($usuarioID, $tipo, $mensaje);

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
        $usuarioID = session()->get('ID');
        $usuarioNombre = session()->get('Nombre');
        $tipoEvento = 'SISTEMA';
        $location = 'LA PAZ';
        $descripcion = session()->get('Nombre') . "HA ENTREGADO EL ENVIO";
        $auditoriaEventoModel = new AuditoriaModel();
        $auditoriaEventoModel->registrarEvento(
            $tipoEvento,
            $usuarioID,
            $usuarioNombre,
            $this->request->getIPAddress(),
            $this->request->getUserAgent(),
            $location,
            $descripcion
        );


        $id_compra = $this->request->getPost('id_compra');
        $compra = new CompraModel();
        $compra->update($id_compra, ['Estado' => 'ENTREGADO']);

        $usuarioID = $compra->obtenerIDUsuarioDeCompra($id_compra)['ID_Cliente'];
        $tipo = 'ENVIO';
        $mensaje = "Tu envio se ha entregado exitosamente.";
        $notificacionModel = new NotificacionModel();
        $notificacionModel->registrarNotificacion($usuarioID, $tipo, $mensaje);

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
    public function cambiarEstado($idProducto, $idCompra, $nuevoEstado)
    {
        $detallecompra = new DetalleCompraModel();
        $detallecompra->cambiarEstadoProducto($idProducto, $idCompra, $nuevoEstado);

        return redirect()->back();
    }




}