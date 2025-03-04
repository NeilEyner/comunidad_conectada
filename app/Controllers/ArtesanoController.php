<?php

namespace App\Controllers;

use App\Models\DetalleCompraModel;
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
use App\Models\NotificacionModel;
use App\Models\AuditoriaModel;

class ArtesanoController extends Controller
{
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
    }
    public function artesano()
    {
        if (session()->get('ID_Rol') != 1) {
            return redirect()->to(base_url('login'));
        }

        $tieneProductoModel = new TieneProductoModel();
        $productoModel = new ProductoModel();
        $categoriaModel = new CategoriaModel();
        $idArtesano = session()->get('ID');
    
        $productos = $tieneProductoModel
        ->select('tiene_producto.ID, producto.Nombre as Nombre, tiene_producto.Precio, tiene_producto.Stock, tiene_producto.Imagen_URL, tiene_producto.Disponibilidad,tiene_producto.Descripcion')
        ->join('producto', 'producto.ID = tiene_producto.ID_Producto')  
        ->where('tiene_producto.ID_Artesano', $idArtesano)
        ->findAll();




        $artesanoId = $this->session->get('ID');

        // Consulta para obtener todas las ventas del artesano
        $builder = $this->db->table('compra c')
            ->select('c.ID as ID_Compra, tp.Imagen_URL as imagen, c.Fecha as Fecha_Compra, 
                     u.Nombre as Cliente, p.Nombre as Producto, dc.Cantidad, 
                     (dc.Cantidad * tp.Precio) as Total_Venta, c.Estado as Estado_Compra')
            ->join('detalle_compra dc', 'c.ID = dc.ID_Compra')
            ->join('usuario u', 'c.ID_Cliente = u.ID')
            ->join('producto p', 'dc.ID_Producto = p.ID')
            ->join('tiene_producto tp', 'p.ID = tp.ID_Producto AND tp.ID_Artesano = dc.ID_Artesano')
            ->where('dc.ID_Artesano', $artesanoId)
            ->orderBy('c.Fecha', 'DESC');
        
        $ventas = $builder->get()->getResultArray();
        $data['productos'] = $productos;
        $data['ventas'] = $ventas;
        $data['productos_list'] = $productoModel->findAll();
        $data['categorias'] = $categoriaModel->findAll();

        return view('dashboard/artesano/arte_dashboard', $data);
    }
    
    public function artesano_producto()
    {
        if (session()->get('ID_Rol') != 1) {
            return redirect()->to(base_url('login'));
        }

        $tieneProductoModel = new TieneProductoModel();
        $productoModel = new ProductoModel();
        $categoriaModel = new CategoriaModel();
        $idArtesano = session()->get('ID');
    
        $productos = $tieneProductoModel
        ->select('producto.Nombre as Nombre, tiene_producto.*')
        ->join('producto', 'producto.ID = tiene_producto.ID_Producto')  
        ->where('tiene_producto.ID_Artesano', $idArtesano)
        ->findAll();

        $data['productos'] = $productos;
        $data['productos_list'] = $productoModel->findAll();
        $data['categorias'] = $categoriaModel->findAll();

        return view('dashboard/artesano/arte_producto', $data);
    }

    public function artesano_editar_producto($idArtesano, $idProducto)
    {

        $usuarioID = session()->get('ID');
        $usuarioNombre = session()->get('Nombre');
        $tipoEvento = 'SISTEMA'; 
        $location = 'LA PAZ'; 
        $descripcion = "El usuario ".session()->get('Nombre')." EDITO PRODUCTO";
        $auditoriaEventoModel = new AuditoriaModel();
        $auditoriaEventoModel->registrarEvento($tipoEvento, $usuarioID, $usuarioNombre, $this->request->getIPAddress(), 
        $this->request->getUserAgent(), $location, $descripcion);

        $model = new TieneProductoModel();
        helper(['form']);
        $producto = $model->where('ID_Artesano', $idArtesano)->where('ID', $idProducto)->first();
        if (!$producto) {
            return redirect()->back()->with('message', 'Producto no encontrado.');
        }
        $rules = [
            'Precio' => 'required',
            'Stock' => 'required|integer',
            'Disponibilidad' => 'required|integer',
        ];

        $imagen = $this->request->getFile('Imagen_URL');
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(FCPATH . 'images/productos/', $nombreImagen);
            $imagenURL = 'images/productos/' . $nombreImagen;
        }
        $data = [
            'ID_Producto' => $this->request->getPost('ID_Producto'),
            'Precio' => $this->request->getPost('Precio'),
            'Stock' => $this->request->getPost('Stock'),
            'Disponibilidad' => $this->request->getPost('Disponibilidad'),
            'Descripcion' => $this->request->getPost('Descripcion'),
        ];

        if (isset($imagenURL)) {
            $data['Imagen_URL'] = $imagenURL;
        }
        $model->where('ID_Artesano', $idArtesano)->where('ID', $idProducto)->update(null, $data);
        return redirect()->to(base_url('dashboard/artesano/arte_producto'))->with('message', 'Producto actualizado correctamente.');
    }

    public function artesano_agregar_producto()
    {
        $usuarioID = session()->get('ID');
        $usuarioNombre = session()->get('Nombre');
        $tipoEvento = 'SISTEMA'; 
        $location = 'LA PAZ'; 
        $descripcion = "El usuario ".session()->get('Nombre')." AGREGO NUEVO PRODUCTO";
        $auditoriaEventoModel = new AuditoriaModel();
        $auditoriaEventoModel->registrarEvento($tipoEvento, $usuarioID, $usuarioNombre, $this->request->getIPAddress(), 
        $this->request->getUserAgent(), $location, $descripcion);


        $usuarioID = session()->get('ID');
        $tipo = 'PRODUCTO'; 
        $mensaje = "Tu producto ha sido agregado."; 
        $notificacionModel = new NotificacionModel();
        $notificacionModel->registrarNotificacion($usuarioID, $tipo, $mensaje);


        helper(['form']);
        $model = new TieneProductoModel();
        $idArtesano = session()->get('ID');

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'ID_Producto' => 'required|integer',
                'Precio' => 'required',
                'Stock' => 'required|integer',
                'Disponibilidad' => 'required|integer',
            ];

            if ($this->validate($rules)) {
                $imagen = $this->request->getFile('Imagen_URL');
                if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
                    $nombreImagen = $imagen->getRandomName();
                    $imagen->move(FCPATH . 'images/productos/', $nombreImagen);
                    $imagenURL = 'images/productos/' . $nombreImagen;
                } else {
                    $imagenURL = 'images/productos/default.png';
                }

                $data = [
                    'ID_Artesano' => $idArtesano,
                    'ID_Producto' => $this->request->getPost('ID_Producto'),
                    'Precio' => $this->request->getPost('Precio'),
                    'Stock' => $this->request->getPost('Stock'),
                    'Disponibilidad' => $this->request->getPost('Disponibilidad'),
                    'Imagen_URL' => $imagenURL,
                    'Descripcion' => $this->request->getPost('Descripcion'),
                    'Fecha_Creacion' => date('Y-m-d H:i:s')
                ];

                if ($model->insert($data)) {
                    return redirect()->to(base_url('dashboard/artesano/arte_producto'))->with('success', 'Producto agregado exitosamente');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Ocurrió un error al agregar el producto');
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }
    }
    public function artesano_eliminar_producto($idArtesano, $idProducto)
    {
        $model = new TieneProductoModel();
        if ($model->where('ID_Artesano', $idArtesano)->where('ID', $idProducto)->first()) {
            $model->where('ID_Artesano', $idArtesano)->where('ID_Producto', $idProducto)->delete();
            return redirect()->back()->with('message', 'Producto eliminado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }
    }

    public function pedido_producto()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        $artesanoId = $this->session->get('ID');

        // Consulta para obtener todas las ventas del artesano
        $builder = $this->db->table('compra c')
        ->select('c.ID as ID_Compra, tp.Imagen_URL as imagen, c.Fecha as Fecha_Compra, 
                 u.Nombre as Cliente, p.Nombre as Producto, dc.Cantidad, 
                 (dc.Cantidad * tp.Precio) as Total_Venta, c.Estado as Estado_Compra')
        ->join('detalle_compra dc', 'c.ID = dc.ID_Compra')
        ->join('tiene_producto tp', 'dc.ID_Producto = tp.ID')
        ->join('producto p', 'p.ID = tp.ID_Producto')
        ->join('usuario u', 'c.ID_Cliente = u.ID')
        ->where('tp.ID_Artesano', $artesanoId)
        ->orderBy('c.Fecha', 'DESC');
    
    $ventas = $builder->get()->getResultArray();
        

        $data = [
            'titulo' => 'Mis Ventas',
            'ventas' => $ventas,
            'usuario' => [
                'nombre' => $this->session->get('Nombre'),
                'imagen' => $this->session->get('Imagen_URL')
            ]
        ];


        return view('dashboard/artesano/pedido_producto', $data);
    }

    public function valoracion_producto()
    {
        $idArtesano = session()->get('ID');

        $productoModel = new TieneProductoModel();
        $data['productos'] = $productoModel->getProductosConValoraciones($idArtesano);

        return view('dashboard/artesano/valoracion_producto', $data);
    }
   
}