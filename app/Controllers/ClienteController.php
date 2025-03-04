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
use App\Models\ValoracionModel;

class ClienteController extends Controller
{
    public function cliente()
    {
        if (!session()->has('ID_Rol')) {
            return redirect()->to(base_url('login'));
        }
        $envioModel = new EnvioModel();
        $envios = $envioModel->getEnviosConDetallesPorCliente(session()->get('ID'));
        $data['envios'] = $envios;
        // var_dump($data['envios']);
        // die();
        $compraModel = new CompraModel();
        $compras = $compraModel->getProductosCompras();
        $data['compras'] = $compras;

        $contenidoModel = new ContenidoModel();
        $data['contenido'] = $contenidoModel->findAll();
        $detalleCompraModel = new CompraModel();
        $carrito = $detalleCompraModel->obtenerDetallesCompras(session()->get('ID'));
        $data['carrito'] = $carrito;
    
        // Devolver la vista con los datos
        return view('global/header', ['titulo' => 'Panel Envios'] + $data)
            . view('dashboard/cliente/cli_dashboard', $data)
            . view('global/footer', $data);
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


    public function calificacion($id)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'producto_id' => 'required|integer',
            'puntuacion' => 'required|integer|greater_than[0]|less_than[6]',
            'comentarios' => 'permit_empty|string|max_length[255]',
        ]);
        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $producto_id = $this->request->getPost('producto_id');
        $puntuacion = $this->request->getPost('puntuacion');
        $comentarios = $this->request->getPost('comentarios');
        $usuario_id = session()->get('ID');
        $fecha = date('Y-m-d');

        $valoracionModel = new ValoracionModel();
        $valoracionModel->insert([
            'ID_Usuario' => $usuario_id,
            'ID_Producto' => $id,
            'Puntuacion' => $puntuacion,
            'Comentario' => $comentarios,
            'Fecha' => $fecha,
        ]);
        return redirect()->back()->with('success', 'Calificación enviada con éxito.');
    }

    public function agregarProducto($id)
    {
        $session = session();
        $idCliente = $session->get('ID');
        if (!$idCliente) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para agregar productos al carrito.');
        }

        $productoId = $this->request->getPost('producto_id');
        $cantidad = $this->request->getPost('cantidad');
        if (!$productoId || !$cantidad || $cantidad <= 0) {
            return redirect()->back()->with('error', 'Datos inválidos.');
        }

        $compraModel = new CompraModel();
        $detalleCompraModel = new DetalleCompraModel();
        $compra = $compraModel->where('ID_Cliente', $idCliente)
            ->where('Estado', 'PENDIENTE')
            ->first();

        if (!$compra) {
            $compraId = $compraModel->insert([
                'ID_Cliente' => $idCliente,
                'Total' => 0,
                'Estado' => 'PENDIENTE'
            ]);
        } else {
            $compraId = $compra['ID'];
        }
        $detalleExistente = $detalleCompraModel->where('ID_Compra', $compraId)
            ->where('ID_Producto', $productoId)
            ->first();

        $productoartesano = new TieneProductoModel();
        $datosProducto = $productoartesano->find($id);
        $datosProducto['Stock'] -= $cantidad;
        $idArtesano = $datosProducto['ID_Artesano'];
        $productoartesano->update($datosProducto['ID'], ['Stock' => $datosProducto['Stock']]);

        if ($detalleExistente) {
            $nuevaCantidad = (int) $detalleExistente['Cantidad'] + (int) $cantidad;
            $db = \Config\Database::connect();
            $sql = "UPDATE detalle_compra SET Cantidad = ? WHERE ID_Compra = ? AND ID_Producto = ?";
            $db->query($sql, [$nuevaCantidad, $compraId, $productoId]);

        } else {
            $datosDetalleCompra = [
                'ID_Compra' => $compraId,
                'ID_Producto' => $productoId,
                'ID_Artesano' => $idArtesano,
                'Cantidad' => $cantidad,
                'Estado' => 'PREPARANDO'
            ];
            $detalleCompraModel->insert($datosDetalleCompra);
        }

        $this->actualizarTotalCompra($compraId);
        return redirect()->back()->with('success', 'Producto agregado al carrito correctamente.');
    }

    private function actualizarTotalCompra($compraId)
    {
        $detalleCompraModel = new DetalleCompraModel();
        $detalles = $detalleCompraModel->where('ID_Compra', $compraId)->findAll();
        $total = 0;
        foreach ($detalles as $detalle) {
            $productoModel = new TieneProductoModel();
            $producto = $productoModel->find($detalle['ID_Producto']);
            if ($producto) {
                $total += $producto['Precio'] * $detalle['Cantidad'];
            }
        }
        $compraModel = new CompraModel();
        $compraModel->update($compraId, ['Total' => $total]);
    }
    public function eliminarProducto($compraId, $productId)
    {
        $session = session();
        $idCliente = $session->get('ID');
        if (!$idCliente) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para eliminar productos del carrito.');
        }
        $detalleCompraModel = new DetalleCompraModel();
        $db = \Config\Database::connect();
        $sql = "DELETE FROM detalle_compra WHERE ID_Compra = ? AND ID_Producto = ?";
        $db->query($sql, [$compraId, $productId]);
        $this->actualizarTotalCompra($compraId);
        return redirect()->back()->with('success', 'Producto eliminado del carrito correctamente.');
    }
    public function eliminarUnProducto($compraId, $productId)
    {
        $session = session();
        $idCliente = $session->get('ID');
        if (!$idCliente) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para eliminar un producto del carrito.');
        }
        $detalleCompraModel = new DetalleCompraModel();
        $prod = $detalleCompraModel->where('ID_Compra', $compraId)->where('ID_Producto', $productId)->findAll();
    
        if (empty($prod)) {
            return redirect()->back()->with('error', 'Producto no encontrado en el carrito.');
        }
        $cantidad = $prod[0]['Cantidad'];
        $tieneProducto = new TieneProductoModel();
        $producto = $tieneProducto->find($productId);
    
        if ($producto) {
            $producto['Stock'] += $cantidad;
            $tieneProducto->update($producto['ID'], ['Stock' => $producto['Stock']]);
        } else {
            return redirect()->back()->with('error', 'Producto no encontrado en el inventario.');
        }
        $this->eliminarProducto($compraId, $productId);
        $this->actualizarTotalCompra($compraId);
        return redirect()->back()->with('success', 'Producto eliminado del carrito correctamente.');
    }
    
    public function vaciarCarrito($compraId)
    {
        $session = session();
        $idCliente = $session->get('ID');
        if (!$idCliente) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para vaciar el carrito.');
        }
        $detalleCompraModel = new DetalleCompraModel();
        $productos = $detalleCompraModel->where('ID_Compra',$compraId)-> findAll();
        foreach ($productos as $product) {
            $tieneProducto = new TieneProductoModel();
            $producto = $tieneProducto->find($product['ID_Producto']);
            $producto['Stock'] += $product['Cantidad'];
            $tieneProducto->update($producto['ID'], ['Stock' => $producto['Stock']]);
        }
        $db = \Config\Database::connect();
        $sql = "DELETE FROM detalle_compra WHERE ID_Compra = ?";
        $db->query($sql, [$compraId]);
        $this->actualizarTotalCompra($compraId);
        return redirect()->back()->with('success', 'Carrito vacío correctamente.');
    }
    public function verCarrito($idCompra)
    {
        $idCliente = session()->get('ID');
        if (!$idCliente) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para ver el carrito.');
        }
        $contenidoModel = new ContenidoModel();
        $detalleCompraModel = new CompraModel();
        $contenido = $contenidoModel->findAll();
        $Shop = $detalleCompraModel->getProductosCompraID($idCompra); //esto es lo que se enviara para el carrito
        $carrito = '';
        if (session()->get('ID_Rol') == null) {
            $usuario = 0;
        } else {
            $usuario = session()->get('ID');
            $carrito = $detalleCompraModel->obtenerDetallesCompras($usuario);
        }
        $data = [
            'titulo' => 'CARRITO',
            'usuario' => $usuario,
            'carrito' => $carrito,
            'Shop' => $Shop,
            'contenido' => $contenido
        ];
        return view('global/header', $data) . view('dashboard/cliente/verCarrito', $data) . view('global/footer');
    }
    public function disminuirProducto($IdCompra, $idProducto)
    {
        $detalleCompraModel = new DetalleCompraModel();
        $detalle = $detalleCompraModel->where('ID_Compra', $IdCompra)->where('ID_Producto', $idProducto)->first();
        if ($detalle['Cantidad'] > 1) {
            $db = \Config\Database::connect();
            $sql = "UPDATE detalle_compra SET Cantidad = Cantidad - 1 WHERE ID_Compra = ? AND ID_Producto = ?";
            $db->query($sql, [$IdCompra, $idProducto]);
        } else {
            $this->eliminarProducto($IdCompra, $idProducto);
        }
        $tieneProducto = new TieneProductoModel();
        $producto = $tieneProducto->find($idProducto);
        $producto['Stock'] += 1;
        $tieneProducto->update($producto['ID'], ['Stock' => $producto['Stock']]);
        $this->actualizarTotalCompra($IdCompra);

        return redirect()->back()->with('success', 'Producto disminuido en el carrito correctamente.');
    }

    public function aumentarProducto($IdCompra, $idProducto)
    {
        $detalleCompraModel = new DetalleCompraModel();
        $db = \Config\Database::connect();
        $sql = "UPDATE detalle_compra SET Cantidad = Cantidad + 1 WHERE ID_Compra = ? AND ID_Producto = ?";
        $db->query($sql, [$IdCompra, $idProducto]);
        $tieneProducto = new TieneProductoModel();
        $datosProducto = $tieneProducto->find($idProducto);
        $datosProducto['Stock'] -= 1;
        $tieneProducto->update($datosProducto['ID'], ['Stock' => $datosProducto['Stock']]);
        $this->actualizarTotalCompra($IdCompra);
        return redirect()->back()->with('success', 'Producto aumentado en el carrito correctamente.');
    }

}