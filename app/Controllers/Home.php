<?php

namespace App\Controllers;
use App\Models\ContenidoModel;
use App\Models\ComunidadModel;
use App\Models\ProductoCategoriaModel;
use App\Models\TieneProductoModel;
use App\Models\CategoriaModel;
use App\Models\DetalleCompraModel;
use App\Models\ProductoModel;
use App\Models\CompraModel;
use App\Models\ValoracionModel;

class Home extends BaseController
{

    public function index(): string
    {
        $tieneProductoModel = new TieneProductoModel();
        $productosall = $tieneProductoModel->findAll();
        $tieneProductoModel = new TieneProductoModel();
        $contenidoModel = new ContenidoModel();
        $categoriaModel = new CategoriaModel();
        $detalleCompraModel = new CompraModel();
        $productos = $tieneProductoModel->getProductosTienda();
        $contenido = $contenidoModel->findAll();
        $categoria = $categoriaModel->findAll();
        $carrito = '';
        if (session()->get('ID_Rol') == null) {
            $usuario = 0;
        } else {
            $usuario = session()->get('ID');
            $carrito = $detalleCompraModel->obtenerDetallesCompras($usuario);
        }
        $data = [
            'titulo' => 'Inicio',
            'productos' => $productos,
            'productoss' => $productosall,
            'categorias' => $categoria,
            'usuario' => $usuario,
            'carrito' => $carrito,
            'contenido' => $contenido
        ];
        return view('global/header', $data) . view('global/homeCarrusel') . view('global/homeCategorias') . view('global/homeProducto') . view('global/footer');
    }

    public function nosotros(): string
    {
        $tieneProductoModel = new TieneProductoModel();
        $productosall = $tieneProductoModel->findAll();
        $tieneProductoModel = new TieneProductoModel();
        $contenidoModel = new ContenidoModel();
        $categoriaModel = new CategoriaModel();
        $detalleCompraModel = new CompraModel();
        $productos = $tieneProductoModel->getProductosTienda();
        $contenido = $contenidoModel->findAll();
        $categoria = $categoriaModel->findAll();
        $carrito = '';
        if (session()->get('ID_Rol') == null) {
            $usuario = 0;
        } else {
            $usuario = session()->get('ID');
            $carrito = $detalleCompraModel->obtenerDetallesCompras($usuario);
        }
        $data = [
            'titulo' => 'Nosotros',
            'productos' => $productos,
            'productoss' => $productosall,
            'categorias' => $categoria,
            'usuario' => $usuario,
            'carrito' => $carrito,
            'contenido' => $contenido
        ];
        return view('global/header', $data) . view('global/nosotros', $data) . view('global/servicios') . view('global/footer');
    }

    public function tienda(): string
    {
        $tieneProductoModel = new TieneProductoModel();
        $contenidoModel = new ContenidoModel();
        $categoriaModel = new CategoriaModel();
        $detalleCompraModel = new CompraModel();
        $productos = $tieneProductoModel->getProductosTienda();
        $contenido = $contenidoModel->findAll();
        $categoria = $categoriaModel->findAll();
        $carrito = '';
        if (session()->get('ID_Rol') == null) {
            $usuario = 0;
        } else {
            $usuario = session()->get('ID');
            $carrito = $detalleCompraModel->obtenerDetallesCompras($usuario);
        }
        $data = [
            'titulo' => 'Tienda',
            'productos' => $productos,
            'categorias' => $categoria,
            'usuario' => $usuario,
            'carrito' => $carrito,
            'contenido' => $contenido
        ];
        return view('global/header', $data) . view('global/tienda', $data) . view('global/footer');
    }
    public function tienda1(): string
    {
        $tieneProductoModel = new TieneProductoModel();
        $contenidoModel = new ContenidoModel();
        $resultado3 = $contenidoModel->findAll();
        $resultado = $tieneProductoModel->prodTienda();
        $categoriaModel = new CategoriaModel();
        $resultado2 = $categoriaModel->findAll();
        $detalleCompraModel = new DetalleCompraModel();
        $carrito = '';
        if (session()->get('ID_Rol') == null) {
            $usuario = 0;
        } else {
            $usuario = session()->get('ID_Rol');
            $carrito = $detalleCompraModel->carritoProd(session()->get('ID'));
        }
        $data = ['titulo' => 'Tienda', 'productos' => $resultado, 'categorias' => $resultado2, 'usuario' => $usuario, 'carrito' => $carrito, 'contenido' => $resultado3];
        return view('global/header', $data) . view('global/tienda', $data) . view('global/footer');
    }

    public function contacto(): string
    {
        $detalleCompraModel = new CompraModel();
        $carrito = '';
        if (session()->get('ID_Rol') == null) {
            $usuario = 0;
        } else {
            $usuario = session()->get('ID_Rol');
            $carrito = $detalleCompraModel->obtenerDetallesCompras($usuario);
        }
        $data = ['titulo' => 'Contacto', 'carrito' => $carrito];
        return view('global/header', $data) . view('global/contacto') . view('global/footer');
    }

    public function comunidades(): string
    {
        $comunidadModel = new ComunidadModel();
        $comunidad = $comunidadModel->findAll();
        $tieneProductoModel = new TieneProductoModel();
        $productosall = $tieneProductoModel->findAll();
        $tieneProductoModel = new TieneProductoModel();
        $contenidoModel = new ContenidoModel();
        $categoriaModel = new CategoriaModel();
        $detalleCompraModel = new CompraModel();
        $productos = $tieneProductoModel->getProductosTienda();
        $contenido = $contenidoModel->findAll();
        $categoria = $categoriaModel->findAll();
        $carrito = '';
        if (session()->get('ID_Rol') == null) {
            $usuario = 0;
        } else {
            $usuario = session()->get('ID');
            $carrito = $detalleCompraModel->obtenerDetallesCompras($usuario);
        }
        $data = [
            'titulo' => 'Inicio',
            'productos' => $productos,
            'comunidad' => $comunidad,
            'categorias' => $categoria,
            'usuario' => $usuario,
            'carrito' => $carrito,
            'contenido' => $contenido
        ];
        return view('global/header', $data) . view('global/comunidades') . view('global/footer');
    }
    public function producto($idA, $idP): string
    {
        $tieneProductoModel = new TieneProductoModel();
        $producto = $tieneProductoModel->getProducto($idA, $idP);
        $contenidoModel = new ContenidoModel();
        $resultado2 = $contenidoModel->findAll();
        $productoModel = new ProductoModel();
        $prod = $productoModel->find($idP);
        $prodR = $tieneProductoModel->prodRelacionados($idP);
        $detalleCompraModel = new CompraModel();
        $carrito = '';
        if (session()->get('ID_Rol') == null) {
            $usuario = 0;
        } else {
            $usuario = session()->get('ID_Rol');
            $carrito = $detalleCompraModel->obtenerDetallesCompras($usuario);
        }
        $data = ['titulo' => 'Producto', 'producto' => $producto, 'prod' => $prod, 'prodR' => $prodR, 'carrito' => $carrito, 'contenido' => $resultado2];
        return view('global/header', $data) . view('global/producto') . view('global/footer');
    }
    public function carrito(): string
    {
        $tieneProductoModel = new TieneProductoModel();
        $resultado2 = $tieneProductoModel->findAll();
        $contenidoModel = new ContenidoModel();
        $resultado3 = $contenidoModel->findAll();
        $comunidadModel = new ComunidadModel();
        $resultado = $comunidadModel->findAll();
        $detalleCompraModel = new CompraModel();
        $carrito = '';
        if (session()->get('ID_Rol') == null) {
            $usuario = 0;

            $data = ['titulo' => 'Inicio', 'productos' => $resultado2, 'contenido' => $resultado3, 'carrito' => $carrito];
            return view('global/header', $data) . view('global/homeCarrusel') . view('global/homeCategorias') . view('global/homeProducto') . view('global/footer');
        } else {
            $usuario = session()->get('ID_Rol');
            $carrito = $detalleCompraModel->obtenerDetallesCompras($usuario);
            $data = ['titulo' => 'Mi Carrito', 'comunidad' => $resultado, 'contenido' => $resultado3, 'carrito' => $carrito];
            return view('global/header', $data) . view('global/carrito') . view('global/footer');
        }

    }

    function anadirProd($idA, $idP, $cant, $precio)
    {
        $tieneProductoModel = new TieneProductoModel();
        $detalleCompraModel = new DetalleCompraModel();
        $compraModel = new CompraModel();
        $prod = $tieneProductoModel->getProducto($idA, $idP);
        //  echo json_encode('productos');
        // $producto='hhhg';
        // echo 'nfkshdk';
        $rol = session()->get('ID_Rol');
        $idC = session()->get('ID');
        $dataC = '';
        $status = 1;
        if ($rol == null) {
            //return json_encode('producto');
            // return json_encode(['status' => 'error', 'message' => 'Rol no autorizado']);
            return $this->response->setJSON(['status' => 0, 'ruta' => base_url('login')]);
        } else {
            $compra = $compraModel->verifCompra($idC);
            //  echo $compra;
            $idCompra = '';
            if ($prod['Stock'] == 0)
                $status = 2;
            elseif ($compra != null) {
                $idCompra = $compra['ID'];
                $detalle = $detalleCompraModel->verifDetalle($idCompra, $idP, $idA);
                $dataC = '';
                if ($detalle != null) {
                    $data = [
                        'Cantidad' => $detalle['Cantidad'] + $cant,
                    ];

                    $detalleCompraModel->actualizarDet($idCompra, $idP, $idA, $data);

                } else {
                    $dataC = [
                        'ID_Compra' => $idCompra,
                        'ID_Producto' => $idP,
                        'ID_Artesano' => $idA,
                        'Cantidad' => $cant,
                    ];
                    $idDet = $detalleCompraModel->insert($dataC);
                }
                $compra = $compraModel->update($idCompra, ['Total' => $compra['Total'] + $cant * $precio]);

                $tieneProductoModel->actualizarProd($idA, $idP, ['Stock' => $prod['Stock'] - $cant]);

            } else {
                $data = [
                    'Fecha' => date('Y-m-d H:i:s'),
                    'Estado' => 'PENDIENTE',
                    'ID_Cliente' => $idC,
                    'Total' => $cant * $precio,
                ];
                $idCompra = $compraModel->insert($data);
                $dataC = [
                    'ID_Compra' => $idCompra,
                    'ID_Producto' => $idP,
                    'ID_Artesano' => $idA,
                    'Cantidad' => $cant,
                ];

                $idDet = $detalleCompraModel->insert($dataC);
            }


            $idDet = 'det';
            $carrito = $detalleCompraModel->carritoProd(session()->get('ID'));
        }
        return $this->response->setJSON(['status' => $status, $dataC, 'det' => $idDet, 'carrito' => $carrito]);

    }
    function anadeProd($idTieneProd, $idA, $idP, $cant, $precio)
    {
        $tieneProductoModel = new TieneProductoModel();
        $detalleCompraModel = new DetalleCompraModel();
        $compraModel = new CompraModel();
        $prod = $tieneProductoModel->find($idTieneProd);
        $rol = session()->get('ID_Rol');
        $idC = session()->get('ID');
        $dataC = '';
        $status = 1;
        if ($rol == null) {
            return $this->response->setJSON(['status' => 0, 'ruta' => base_url('login')]);
        } else {
            $compra = $compraModel->verifCompra($idC);
            $idCompra = '';
            if ($prod['Stock'] == 0)
                $status = 2;
            elseif ($compra != null) {
                $idCompra = $compra['ID'];
                $detalle = $detalleCompraModel->verifDetalle($idCompra, $idP, $idA);
                $dataC = '';
                if ($detalle != null) {
                    $data = [
                        'Cantidad' => $detalle['Cantidad'] + $cant,
                    ];
                    $detalleCompraModel->actualizarDet($idCompra, $idP, $idA, $data);
                } else {
                    $dataC = [
                        'ID_Compra' => $idCompra,
                        'ID_Producto' => $idP,
                        'ID_Artesano' => $idA,
                        'Cantidad' => $cant,
                    ];
                    $idDet = $detalleCompraModel->insert($dataC);
                }
                $compra = $compraModel->update($idCompra, ['Total' => $compra['Total'] + $cant * $precio]);
                $tieneProductoModel->actualizarProd($idA, $idP, ['Stock' => $prod['Stock'] - $cant]);

            } else {
                $data = [
                    'Fecha' => date('Y-m-d H:i:s'),
                    'Estado' => 'PENDIENTE',
                    'ID_Cliente' => $idC,
                    'Total' => $cant * $precio,
                ];
                $idCompra = $compraModel->insert($data);
                $dataC = [
                    'ID_Compra' => $idCompra,
                    'ID_Producto' => $idP,
                    'ID_Artesano' => $idA,
                    'Cantidad' => $cant,
                ];
                $idDet = $detalleCompraModel->insert($dataC);
            }
            $idDet = 'det';
            $carrito = $detalleCompraModel->carritoProd(session()->get('ID'));
        }
        return $this->response->setJSON(['status' => $status, $dataC, 'det' => $idDet, 'carrito' => $carrito]);

    }

    function calificar($idP, $idA, $val)
    {
        $valoracionModel = new ValoracionModel();
        $idC = session()->get('ID');
        $valoracion = $valoracionModel->verifValoracion($idC, $idP, $idA);
        if ($valoracion != null) {
            return $this->response->setJSON(['status' => 0]);
        }
        $data = [
            'ID_Usuario' => $idC,
            'ID_Producto' => $idP,
            'ID_Artesano' => $idA,
            'Puntuacion' => $val,
            'Fecha' => date('Y-m-d H:i:s'),

        ];
        $valoracionModel->insert($data);
        $puntos = $valoracionModel->puntaje($idP, $idA);
        $puntaje = (15 + $puntos->Puntaje) / ($puntos->Num + 5);
        $puntaje = round($puntaje, 1);
        return $this->response->setJSON(['status' => 1, 'idArtesano' => $idA, 'puntaje' => $puntaje]);

    }



}
