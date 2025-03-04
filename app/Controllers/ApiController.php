<?php

namespace App\Controllers;

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

use CodeIgniter\RESTful\ResourceController;

class ApiController extends ResourceController
{
    const BASE_URL = 'http://192.168.205.207/comunidad_conectada/public/';
    public function api_login()
    {
        $email = $this->request->getPost('Correo_electronico');
        $password = $this->request->getPost('Contrasena');

        $model = new UsuarioModel();
        $user = $model->where('Correo_electronico', $email)->first();

        if ($user && password_verify($password, $user['Contrasena'])) {
            if ($user['Estado'] !== 'ACTIVO') {
                return $this->respond([
                    'status' => 'error',
                    'message' => 'Tu cuenta no está activa. Contacta al administrador.'
                ], 403);
            }

            return $this->respond([
                'status' => 'success',
                'message' => 'Inicio de sesión exitoso',
                'data' => [
                    'ID' => $user['ID'],
                    'Nombre' => $user['Nombre'],
                    'Correo_electronico' => $user['Correo_electronico'],
                    'ID_Rol' => $user['ID_Rol'],
                    'Imagen_URL' => $user['Imagen_URL'],
                    'Direccion' => $user['Direccion'],
                    'ID_Comunidad' => $user['ID_Comunidad'],
                    'Latitud' => $user['Latitud'],
                    'Longitud' => $user['Longitud']
                ]
            ]);
        } else {
            return $this->respond([
                'status' => 'error',
                'message' => 'Credenciales incorrectas'
            ], 401);
        }
    }
    public function listarUsuarios()
    {
        $usuarioModel = new UsuarioModel();
        $usuarios = $usuarioModel->findAll();
        foreach ($usuarios as &$usuario) {
            $usuario['imagen_url'] = self::BASE_URL . $usuario['Imagen_URL'];
        }
        return $this->respond($usuarios);
    }

    // 
    public function registrarUsuario()
    {
        $data = $this->request->getJSON(true);
        $usuarioModel = new UsuarioModel();

        // Validaciones básicas
        $validation = \Config\Services::validation();
        $validation->setRules([
            'Nombre' => 'required',
            'Correo_electronico' => 'required|valid_email|is_unique[usuario.Correo_electronico]',
            'Contrasena' => 'required|min_length[6]',
        ]);

        if (!$validation->run($data)) {
            return $this->failValidationErrors($validation->getErrors());
        }

        // Hashear contraseña
        $data['Contrasena'] = password_hash($data['Contrasena'], PASSWORD_DEFAULT);
        $data['Estado'] = 'INACTIVO';

        $usuarioId = $usuarioModel->insert($data);

        return $this->respondCreated([
            'mensaje' => 'Usuario registrado',
            'usuario_id' => $usuarioId
        ]);
    }

    public function listarProductos()
    {
        $db = \Config\Database::connect();
        $query = $db->query("
             SELECT 
                tp.ID AS ID,
                p.Nombre, 
                tp.Precio,
                tp.Stock, 
                tp.Imagen_URL, 
                tp.Descripcion
            FROM tiene_producto tp
            JOIN producto p ON p.ID = tp.ID_Producto
            WHERE tp.Disponibilidad = 1 AND tp.stock > 0 limit 20;
         ");
        $productos = $query->getResult();

        foreach ($productos as &$producto) {
            $producto->imagen_url = $producto->Imagen_URL
                ? self::BASE_URL . $producto->Imagen_URL
                : null;
        }
        return $this->respond($productos);
    }

    public function listarProductosPorArtesano($idArtesano)
    {
        $productoModel = new ProductoModel();
        $productos = $productoModel->select('tiene_producto.ID, producto.Nombre, tiene_producto.Precio, 
        tiene_producto.Stock, tiene_producto.Disponibilidad, tiene_producto.Imagen_URL, tiene_producto.Descripcion')
            ->join('tiene_producto', 'tiene_producto.ID_Producto = producto.ID')
            ->where('tiene_producto.ID_Artesano', $idArtesano)
            ->findAll();
        foreach ($productos as &$producto) {
            $producto['imagen_url'] = self::BASE_URL . $producto['Imagen_URL'];
        }
        return $this->respond($productos);
    }
    public function obtenerSobreNosotros()
    {
        $contenidoPaginaModel = new ContenidoPaginaModel();
        $sobreNosotros = $contenidoPaginaModel
            ->where('Titulo', 'Misión')
            ->where('Tipo_contenido', 'MISION')
            ->first();

        if ($sobreNosotros) {
            return $this->respond(['contenido' => $sobreNosotros['Contenido']]);
        } else {
            return $this->failNotFound('Contenido "Sobre Nosotros" no encontrado.');
        }
    }
    public function obtenerCarousel()
    {
        $contenidoPaginaModel = new ContenidoPaginaModel();
        $carousel = $contenidoPaginaModel
            ->where('Tipo_contenido', 'CARROUSEL')
            ->findAll();
        foreach ($carousel as &$slide) {
            $slide['Imagen'] = rtrim(self::BASE_URL, '/') . '/' . ltrim($slide['Imagen'], './');
        }
        return $this->respond([
            'rows' => $carousel
        ]);
    }
    public function cambiarEstado($id)
    {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($id);
        if (!$usuario) {
            return $this->failNotFound('Usuario no encontrado');
        }
        $nuevoEstado = $usuario['Estado'] === 'ACTIVO' ? 'INACTIVO' : 'ACTIVO';
        $usuarioModel->update($id, ['Estado' => $nuevoEstado]);
        return $this->respond(['mensaje' => 'Estado cambiado exitosamente']);
    }
    public function aumentarStock($idProducto)
    {
        $tieneProductoModel = new TieneProductoModel();
        $tieneProducto = $tieneProductoModel->find($idProducto);
        if (!$tieneProducto) {
            return $this->failNotFound('Producto no encontrado');
        }
        $nuevoStock = $tieneProducto['Stock'] + 1;
        $tieneProductoModel->update($idProducto, ['Stock' => $nuevoStock]);
        return $this->respond(['mensaje' => 'Stock aumentado exitosamente']);
    }
    public function reducirStock($idStock)
    {
        $tieneProductoModel = new TieneProductoModel();
        $tieneProducto = $tieneProductoModel->find($idStock);
        if (!$tieneProducto) {
            return $this->failNotFound('Producto no encontrado');
        }
        $nuevoStock = $tieneProducto['Stock'] - 1;
        $tieneProductoModel->update($idStock, ['Stock' => $nuevoStock]);
        return $this->respond(['mensaje' => 'Stock reducido exitosamente']);
    }
    public function disponibleProducto($idProducto)
    {
        $tieneProductoModel = new TieneProductoModel();
        $tieneProducto = $tieneProductoModel->find($idProducto);
        if (!$tieneProducto) {
            return $this->failNotFound('Producto no encontrado');
        }
        $nuevoEstado = $tieneProducto['Disponibilidad'] == 1 ? 0 : 1;
        $tieneProductoModel->update($idProducto, ['Disponibilidad' => $nuevoEstado]);
        return $this->respond(['mensaje' => 'Disponibilidad cambiada exitosamente']);
    }

    public function compraUsuario($idUsuario)
    {
        $compraModel = new CompraModel();
        $detalleCompraModel = new DetalleCompraModel();
        $compras = $compraModel->getComprasByUsuario($idUsuario);
        if (empty($compras)) {
            return $this->failNotFound('No hay compras para este usuario');
        }
        foreach ($compras as &$compra) {
            $detalleCompra = $detalleCompraModel->getDetalleCompraByCompra($compra['ID']);
            foreach ($detalleCompra as &$detalle) {
                $detalle['Imagen_URL'] = rtrim(self::BASE_URL, '/') . '/' . ltrim($detalle['Imagen_URL'], './');
            }
            $compra['detalles'] = $detalleCompra;
        }
        return $this->respond($compras);
    }
    public function envioUsuario($idUsuario)
    {
        $envioModel = new EnvioModel();
        $detalleEnvioModel = new DetalleCompraModel();
        $envios = $envioModel->getDetalleEnvioByDelivery($idUsuario);
        if (empty($envios)) {
            return $this->failNotFound('No hay envíos para este usuario');
        }
        foreach ($envios as &$envio) {
            $detalleEnvio = $detalleEnvioModel->getDetalleCompraByCompra($envio['ID_Compra']);
            foreach ($detalleEnvio as &$detalle) {
                $detalle['Imagen_URL'] = rtrim(self::BASE_URL, '/') . '/' . ltrim($detalle['Imagen_URL'], './');
            }
            $envio['detalles'] = $detalleEnvio;
        }
        return $this->respond($envios);
    }
    public function confirmarEnvio($idEnvio){
        $envioModel = new EnvioModel();
        $envio = $envioModel->find($idEnvio);
        if (!$envio) {
            return $this->failNotFound('Envío no encontrado');
        }
        $envioModel->update($idEnvio, ['Estado' => 'ENTREGADO']);
        return $this->respond(['mensaje' => 'Envío confirmado exitosamente']);
    }


}
