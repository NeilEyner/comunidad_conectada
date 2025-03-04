<?php

namespace App\Controllers;

use App\Models\PagoModel;
use App\Models\CompraModel;
use App\Models\UsuarioModel;
use App\Models\ComunidadModel;
use App\Models\rolModel;
use App\Models\ContenidoPaginaModel;
use App\Models\EnvioModel;
use App\Models\ProductoModel;
use App\Models\TieneProductoModel;
use App\Models\CategoriaModel;
use App\Models\DetalleCompraModel;
use App\Models\ContenidoModel;
use App\Models\NotificacionModel;
use App\Models\AuditoriaModel;
use App\Models\TransporteModel;

class PagoController extends BaseController
{
    public function mostrarMetodosPago($idCompra)
    {
        $compraModel = new CompraModel();
        $compra = $compraModel->find($idCompra);

        $contenidoPaginaModel = new ContenidoPaginaModel();
        $transferenciaBancaria = $contenidoPaginaModel->where('Tipo_contenido', 'OTRO')
            ->where('Titulo', 'Transferencia Bancaria')
            ->first();
        $codigoQR = $contenidoPaginaModel->where('Tipo_contenido', 'OTRO')
            ->where('Titulo', 'QR')
            ->first();
        $contenidoGeneral = $contenidoPaginaModel->findAll();
        $categoriaModel = new CategoriaModel();
        $categoriasDisponibles = $categoriaModel->findAll();

        $compraModel = new CompraModel();
        $usuario = session()->get('ID');
        $tieneProductoModel = new DetalleCompraModel();
        $productosDisponibles = $compraModel->obtenerDetallesComprasID($idCompra);
        $carrito = '';
        if (session()->get('ID_Rol') == null) {
            $usuario = 0;
        } else {
            $usuario = session()->get('ID');
            $carrito = $compraModel->obtenerDetallesCompras($usuario);
        }

        $comunidadModel = new ComunidadModel();
        $comunidadesDisponibles = $comunidadModel->findAll();

        $data = [
            'ID' => $idCompra,
            'compra' => $compra,
            'titulo' => 'Pagos',
            'productos' => $productosDisponibles,
            'categorias' => $categoriasDisponibles,
            'carrito' => $carrito,
            'transferencia' => $transferenciaBancaria,
            'qr' => $codigoQR,
            'tieneProductoModel' => $tieneProductoModel,
            'contenido' => $contenidoGeneral,
            'comunidades' => $comunidadesDisponibles,
        ];

        return view('global/header', $data) . view('pagos/metodos_pagos', $data) . view('global/footer');
    }

    public function procesar_pago($id_compra)
    {
        $usuarioID = session()->get('ID');
        $usuarioNombre = session()->get('Nombre');
        $tipoEvento = 'COMPRA';
        $location = 'LA PAZ';
        $descripcion = session()->get('Nombre') . "HA REALIZADO UNA COMPRA";
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


        $usuarioID = session()->get('ID');
        $tipo = 'COMPRA';
        $mensaje = "Tu compra se ha realizado exitosamente.";
        $notificacionModel = new NotificacionModel();
        $notificacionModel->registrarNotificacion($usuarioID, $tipo, $mensaje);

        $envioModel = new EnvioModel();
        $pagoModel = new PagoModel();
        $compraModel = new CompraModel();

        $compraModel = new CompraModel();
        $detalleCompraModel = new DetalleCompraModel();
        $tieneProductoModel = new TieneProductoModel();

        // // Obtener la compra con el ID proporcionado
        // $compra = $compraModel->find($id_compra);
        // if ($compra) {
        //     $detalleCompra = $detalleCompraModel->where('ID_Compra', $id_compra)->findAll();
        //     $db = \Config\Database::connect();
        //     $db->transBegin();
        //     try {
        //         foreach ($detalleCompra as $detalle) {
        //             $idArtesano = $detalle['ID_Artesano'];
        //             $idProducto = $detalle['ID_Producto'];
        //             $cantidadVendida = $detalle['Cantidad'];
        //             $productoArtesano = $tieneProductoModel->where([
        //                 'ID_Artesano' => $idArtesano,
        //                 'ID' => $idProducto
        //             ])->first();

        //             if ($productoArtesano) {
        //                 $nuevoStock = max(0, $productoArtesano['Stock'] - $cantidadVendida);
        //                 $tieneProductoModel->where([
        //                     'ID_Artesano' => $productoArtesano['ID_Artesano'],
        //                     'ID' => $productoArtesano['ID_Producto']
        //                 ])
        //                     ->set('Stock', $nuevoStock)
        //                     ->update();
        //             }
        //         }
        //         $db->transCommit();
        //     } catch (\Exception $e) {
        //         $db->transRollback();
        //         throw $e;
        //     }
        // }
        // Procesar los datos del formulario de envío
        $dataEnvio = [
            'ID_Compra' => $this->request->getPost('id_compra'),
            'ID_Transporte' => $this->request->getPost('tipo_transporte'),
            'Comunidad_Destino' => $this->request->getPost('Comunidad_Destino'),
            'Direccion_Destino' => $this->request->getPost('Direccion_Destino'),
            'Latitud' => $this->request->getPost('latitud'),
            'Longitud' => $this->request->getPost('longitud'),
            'Estado' => 'PREPARANDO',
        ];

        if (!$envioModel->insert($dataEnvio)) {
            return redirect()->back()->withInput()->with('error', 'No se pudo procesar el envío.');
        }

        // Validar los datos del formulario de pago
        $validation = $this->validate([
            'metodo_pago' => 'required',
            'comprobante' => 'permit_empty|uploaded[comprobante]|max_size[comprobante,2048]|ext_in[comprobante,jpg,jpeg,png,pdf]'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        // Procesar el comprobante
        $comprobante = $this->request->getFile('comprobante');
        $comprobanteURL = null;

        if ($comprobante && $comprobante->isValid() && !$comprobante->hasMoved()) {
            try {
                $rutaComprobantes = FCPATH . 'images/comprobantes/';
                $nombreComprobante = $comprobante->getRandomName();
                $comprobante->move($rutaComprobantes, $nombreComprobante);
                $comprobanteURL = 'images/comprobantes/' . $nombreComprobante;
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Error al subir el comprobante: ' . $e->getMessage());
            }
        }

        // Crear los datos de pago
        $pagoData = [
            'ID_Cliente' => session()->get('ID'),
            'ID_Compra' => $this->request->getPost('id_compra'),
            'Metodo_pago' => $this->request->getPost('metodo_pago'),
            'Estado' => 'COMPLETADO',
            'IMG_Comprobante' => $comprobanteURL
        ];

        $compra = $compraModel->find($this->request->getPost('id_compra'));
        $tiene = new $detalleCompraModel();
        $com = $tiene->where('ID_Compra', $id_compra)->findAll();
        foreach ($com as $c) {
            $tipo = 'PRODUCTO';
            $mensaje = "Tu producto ha sido comprado.";
            $notificacionModel = new NotificacionModel();
            $notificacionModel->registrarNotificacion($c['ID_Artesano'], $tipo, $mensaje);
        }

        if (!$compra) {
            return redirect()->back()->with('error', 'Compra no encontrada.');
        }
        $compra['Estado'] = 'EN PROCESO';
        $compraModel->update($compra['ID'], ['Estado' => 'EN PROCESO']);
        if ($pagoModel->insert($pagoData)) {
            return redirect()->to(base_url())->with('success', 'Pago procesado. En espera de verificación.');
        } else {
            $error = $pagoModel->errors();
            return redirect()->back()->withInput()->with('error', 'Error al procesar el pago: ' . json_encode($error));
        }

    }



}