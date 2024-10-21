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

class ArtesanoController extends Controller
{
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
        ->select('producto.Nombre as Nombre, tiene_producto.Precio, tiene_producto.Stock, tiene_producto.Imagen_URL, tiene_producto.Disponibilidad,tiene_producto.Descripcion')
        ->join('producto', 'producto.ID = tiene_producto.ID_Producto')  
        ->where('tiene_producto.ID_Artesano', $idArtesano)
        ->findAll();

        $data['productos'] = $productos;
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
        $model = new TieneProductoModel();
        helper(['form']);
        $producto = $model->where('ID_Artesano', $idArtesano)->where('ID_Producto', $idProducto)->first();

        if (!$producto) {
            return redirect()->back()->with('message', 'Producto no encontrado.');
        }
        $rules = [
            'Precio' => 'required|decimal',
            'Stock' => 'required|integer',
            'Disponibilidad' => 'required|integer',
        ];

        $imagen = $this->request->getFile('Imagen_URL');

        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(FCPATH . 'images/productos/', $nombreImagen);
            $imagenURL = base_url('images/productos/' . $nombreImagen);
        }

        $data = [
            'Precio' => $this->request->getPost('Precio'),
            'Stock' => $this->request->getPost('Stock'),
            'Disponibilidad' => $this->request->getPost('Disponibilidad'),
        ];

        if (isset($imagenURL)) {
            $data['Imagen_URL'] = $imagenURL;
        }

        $model->where('ID_Artesano', $idArtesano)->where('ID_Producto', $idProducto)->update(null, $data);

        return redirect()->to(base_url('dashboard/artesano/arte_producto'))->with('message', 'Producto actualizado correctamente.');
    }

    public function artesano_agregar_producto()
    {
        helper(['form']);
        $model = new TieneProductoModel();
        $idArtesano = session()->get('ID');

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'ID_Producto' => 'required|integer',
                'Precio' => 'required|decimal',
                'Stock' => 'required|integer',
                'Disponibilidad' => 'required|integer',
            ];

            if ($this->validate($rules)) {
                $imagen = $this->request->getFile('Imagen_URL');
                if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
                    $nombreImagen = $imagen->getRandomName();
                    $imagen->move(FCPATH . 'images/productos/', $nombreImagen);
                    $imagenURL = base_url('images/productos/' . $nombreImagen);
                } else {
                    $imagenURL = base_url('images/productos/default.png');
                }

                $data = [
                    'ID_Artesano' => $idArtesano,
                    'ID_Producto' => $this->request->getPost('ID_Producto'),
                    'Precio' => $this->request->getPost('Precio'),
                    'Stock' => $this->request->getPost('Stock'),
                    'Disponibilidad' => $this->request->getPost('Disponibilidad'),
                    'Imagen_URL' => $imagenURL,
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
        if ($model->where('ID_Artesano', $idArtesano)->where('ID_Producto', $idProducto)->first()) {
            $model->where('ID_Artesano', $idArtesano)->where('ID_Producto', $idProducto)->delete();
            return redirect()->back()->with('message', 'Producto eliminado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }
    }

    public function pedido_producto()
    {
        return view('dashboard/artesano/pedido_producto');
    }

    public function valoracion_producto()
    {
        return view('dashboard/artesano/valoracion_producto');
    }
   
}