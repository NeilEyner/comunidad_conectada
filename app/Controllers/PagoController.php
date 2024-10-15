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


class PagoController extends BaseController
{
    public function mostrar_metodos_pago($id_compra)
    {

        $compraModel = new CompraModel();
        $compra = $compraModel->find($id_compra);
        // $data['compra'] = $compra; 


        $contenidoModel = new ContenidoPaginaModel();

        // Fetch bank account details
        $transferencia = $contenidoModel->where('Tipo_contenido', 'OTRO')
            ->where('Titulo', 'Transferencia Bancaria')
            ->first();

        // Fetch QR code information
        $qr = $contenidoModel->where('Tipo_contenido', 'OTRO')
            ->where('Titulo', 'QR')
            ->first();


        $tieneProductoModel = new TieneProductoModel();
        $resultado = $tieneProductoModel->findAll();


        $categoriaModel = new CategoriaModel();
        $resultado2 = $categoriaModel->findAll();
        $detalleCompraModel = new DetalleCompraModel();
        
        $carrito = '';
        if (session()->get('ID_Rol') == null) {
            $usuario = 0;
        } else {
            $usuario = session()->get('ID_Rol');
            $carrito = $detalleCompraModel->where('ID_Compra', $id_compra)->carritoProd(session()->get('ID'));
        }
        $data = [
            'ID' => $id_compra,
            'compra' => $compra,
            'titulo' => 'Pagos',
            'productos' => $resultado,
            'categorias' => $resultado2,
            'usuario' => $usuario,
            'carrito' => $carrito,
            'transferencia' => $transferencia,
            'qr' => $qr,
            'tieneProductoModel' => $tieneProductoModel
        ];
        // return view('pagos/metodos_pagos', $data);
        return view('global/header', $data) . view('pagos/metodos_pagos', $data) . view('global/footer');
    }

    public function procesar_pago()
    {
        $pagoModel = new PagoModel();
        $validation = $this->validate([
            'metodo_pago' => 'required',
            'comprobante' => 'uploaded[comprobante]|max_size[comprobante,2048]|ext_in[comprobante,jpg,jpeg,png,pdf]'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $comprobante = $this->request->getFile('comprobante');
        $comprobanteURL = null;

        if ($comprobante && $comprobante->isValid() && !$comprobante->hasMoved()) {
            try {
                $rutaComprobantes = FCPATH . 'images/comprobantes/';
                $nombreComprobante = $comprobante->getRandomName();
                $comprobante->move($rutaComprobantes, $nombreComprobante);
                $comprobanteURL = base_url('images/comprobantes/' . $nombreComprobante);
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Error al subir el comprobante: ' . $e->getMessage());
            }
        }
        $pagoData = [
            'ID_Cliente' => session()->get('ID'),
            'ID_Compra' => $this->request->getPost('id_compra'),
            'Metodo_pago' => $this->request->getPost('metodo_pago'),
            'Estado' => 'PENDIENTE',
            'IMG_Comprobante' => $comprobanteURL
        ];

        $compraModel = new CompraModel();
        $compra = $compraModel->find($this->request->getPost('id_compra'));
        
        if ($compra) {
            $compra->Estado = 'PROCESADO';
            $compraModel->save($compra);
        } else {
            return redirect()->back()->with('error', 'Compra no encontrada.');
        }
        
        if ($pagoModel->insert($pagoData)) {
            return redirect()->to(base_url())->with('success', 'Pago procesado. En espera de verificación.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al procesar el pago.');
        }
    }


}