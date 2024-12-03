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

    // Registrar usuario
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

    // Listar productos
    public function listarProductos()
    {
        $db = \Config\Database::connect();
        $query = $db->query("
             SELECT 
                ROW_NUMBER() OVER (ORDER BY p.Nombre) AS ID,
                p.Nombre, 
                tp.Precio,
                tp.Stock, 
                tp.Imagen_URL, 
                tp.Descripcion
            FROM tiene_producto tp
            JOIN producto p ON p.ID = tp.ID_Producto
            WHERE tp.Disponibilidad = 1 AND tp.stock > 0;
         ");
        $productos = $query->getResult();

        foreach ($productos as &$producto) {
            $producto->imagen_url = $producto->Imagen_URL
                ? self::BASE_URL . $producto->Imagen_URL
                : null;
        }

        return $this->respond($productos);
    }

    // Realizar compra
    public function realizarCompra()
    {
        $data = $this->request->getJSON(true);
        $compraModel = new CompraModel();
        $detalleCompraModel = new DetalleCompraModel();
        $db = \Config\Database::connect();

        $db->transStart();

        try {
            // Crear compra
            $compraData = [
                'ID_Cliente' => $data['ID_Cliente'],
                'Total' => $data['Total'],
                'Estado' => 'PENDIENTE'
            ];
            $compraId = $compraModel->insert($compraData);

            // Guardar detalles de compra
            foreach ($data['Productos'] as $producto) {
                $detalleCompraModel->insert([
                    'ID_Compra' => $compraId,
                    'ID_Producto' => $producto['ID_Producto'],
                    'Cantidad' => $producto['Cantidad']
                ]);
            }

            $db->transComplete();

            return $this->respondCreated([
                'mensaje' => 'Compra realizada',
                'compra_id' => $compraId
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->failServerError($e->getMessage());
        }
    }

    // Listar compras de un usuario
    public function listarComprasUsuario($usuarioId)
    {
        $db = \Config\Database::connect();
        $query = $db->query("
             SELECT c.*, p.Estado as Estado_Pago, 
                    GROUP_CONCAT(pr.Nombre SEPARATOR ', ') as Productos
             FROM compra c
             LEFT JOIN pago p ON p.ID_Compra = c.ID
             LEFT JOIN detalle_compra dc ON dc.ID_Compra = c.ID
             LEFT JOIN producto pr ON pr.ID = dc.ID_Producto
             WHERE c.ID_Cliente = $usuarioId
             GROUP BY c.ID
         ");
        $compras = $query->getResult();

        return $this->respond($compras);
    }
    // Método para listar usuarios con rol
    public function listarUsuariosr()
    {
        $usuarioModel = new UsuarioModel();
        $usuarios = $usuarioModel->select('usuario.ID, usuario.Nombre, usuario.Correo_electronico, usuario.Telefono, usuario.Direccion, usuario.Estado, usuario.Imagen_URL, rol.Nombre as Rol')
            ->join('rol', 'rol.ID = usuario.ID_Rol')
            ->findAll();

        foreach ($usuarios as &$usuario) {
            $usuario['imagen_url'] = self::BASE_URL . $usuario['Imagen_URL'];
        }

        return $this->respond($usuarios);
    }

    // Método para obtener detalles de un usuario
    public function obtenerUsuario($id)
    {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->select('usuario.ID, usuario.Nombre, usuario.Correo_electronico, usuario.Telefono, usuario.Direccion, usuario.Estado, usuario.Imagen_URL, rol.Nombre as Rol')
            ->join('rol', 'rol.ID = usuario.ID_Rol')
            ->where('usuario.ID', $id)
            ->first();

        if (!$usuario) {
            return $this->failNotFound("Usuario no encontrado.");
        }

        $usuario['imagen_url'] = self::BASE_URL . $usuario['Imagen_URL'];

        return $this->respond($usuario);
    }

    // Método para listar productos por artesano
    public function listarProductosPorArtesano($idArtesano)
    {
        $productoModel = new ProductoModel();
        $productos = $productoModel->select('tiene_producto.ID_Producto, producto.Nombre, tiene_producto.Precio, tiene_producto.Stock, tiene_producto.Disponibilidad, tiene_producto.Imagen_URL, tiene_producto.Descripcion')
            ->join('tiene_producto', 'tiene_producto.ID_Producto = producto.ID')
            ->where('tiene_producto.ID_Artesano', $idArtesano)
            ->findAll();

        foreach ($productos as &$producto) {
            $producto['imagen_url'] = self::BASE_URL . $producto['Imagen_URL'];
        }

        return $this->respond($productos);
    }

    // Método para listar compras de un cliente
    public function listarComprasPorCliente($idCliente)
    {
        $compraModel = new \App\Models\CompraModel();
        $compras = $compraModel->select('compra.ID, compra.Fecha, compra.Estado, compra.Total')
            ->where('compra.ID_Cliente', $idCliente)
            ->findAll();

        return $this->respond($compras);
    }

    // Método para obtener detalles de una compra
    public function obtenerDetalleCompra($idCompra)
    {
        $detalleCompraModel = new \App\Models\DetalleCompraModel();
        $detalleCompra = $detalleCompraModel->select([
            'detalle_compra.ID_Compra',
            'producto.Nombre as Producto',
            'producto.Descripcion',
            'detalle_compra.Cantidad',
            'detalle_compra.Precio_Unitario',
            'detalle_compra.Cantidad * detalle_compra.Precio_Unitario as Subtotal',
            'compra.Fecha as Fecha_Compra',
            'compra.Metodo_Pago',
            'compra.Total as Total_Compra'
        ])
            ->join('producto', 'producto.ID_Producto = detalle_compra.ID_Producto')
            ->join('compra', 'compra.ID_Compra = detalle_compra.ID_Compra')
            ->where('detalle_compra.ID_Compra', $idCompra)
            ->findAll();

        return $this->respond($detalleCompra);
    }


    // Método para listar categorías con cantidad de productos
    public function listarCategorias()
    {
        $categoriaModel = new \App\Models\CategoriaModel();
        $categorias = $categoriaModel->select('categoria.ID, categoria.Nombre, categoria.Descripcion, COUNT(producto_categoria.ID_Producto) as CantidadProductos')
            ->join('producto_categoria', 'producto_categoria.ID_Categoria = categoria.ID', 'left')
            ->groupBy('categoria.ID')
            ->findAll();

        return $this->respond($categorias);
    }

    // Método para listar comunidades
    public function listarComunidades()
    {
        $comunidadModel = new \App\Models\ComunidadModel();
        $comunidades = $comunidadModel->select('ID, Nombre, Descripcion, Ubicacion, Latitud, Longitud, Imagen')
            ->findAll();

        foreach ($comunidades as &$comunidad) {
            $comunidad['imagen_url'] = self::BASE_URL . $comunidad['Imagen'];
        }

        return $this->respond($comunidades);
    }

}
