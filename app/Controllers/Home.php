<?php

namespace App\Controllers;
use App\Models\ContenidoModel;
use App\Models\ComunidadModel;
use App\Models\TieneProductoModel;
use App\Models\CategoriaModel;
use App\Models\DetalleCompraModel;
use App\Models\ProductoModel;
use App\Models\CompraModel;

class Home extends BaseController{

    public function index(): string
    {
        $tieneProductoModel = new TieneProductoModel();
        $resultado = $tieneProductoModel->findAll();
        $contenidoModel = new ContenidoModel();
        $resultado2 = $contenidoModel->findAll();
        $detalleCompraModel= new DetalleCompraModel();
        $carrito='';
        if (session()->get('ID_Rol') == null) {
            $usuario=0;
        }else{
            $usuario=session()->get('ID_Rol');
            $carrito=$detalleCompraModel->carritoProd(session()->get('ID'));
        }
        $data=['titulo'=>'Comunidades','productos'=>$resultado,'contenido'=>$resultado2,'carrito'=>$carrito];
        return view('global/header',$data).view('global/homeCarrusel').view('global/homeCategorias') .view('global/homeProducto'). view('global/footer');
    }

    public function nosotros(): string
    {
        $contenidoModel = new ContenidoModel();
        $resultado = $contenidoModel->findAll();
        $detalleCompraModel= new DetalleCompraModel();
        $carrito='';
        if (session()->get('ID_Rol') == null) {
            $usuario=0;
        }else{
            $usuario=session()->get('ID_Rol');
            $carrito=$detalleCompraModel->carritoProd(session()->get('ID'));
        }
        $data=['titulo'=>'Nosotros','contenido'=>$resultado,'carrito'=>$carrito];
        return view('global/header',$data).view('global/nosotros',$data).view('global/servicios') . view('global/footer');
    }

    public function tienda(): string
    {
        $tieneProductoModel = new TieneProductoModel();
        // $resultado = $tieneProductoModel->findAll();
        // $resultado = $tieneProductoModel->where('Disponibilidad','1')->where('Stock>1')->findAll();
        $resultado= $tieneProductoModel->prodTienda();
        $categoriaModel = new CategoriaModel();
        $resultado2 = $categoriaModel->findAll();
        $detalleCompraModel= new DetalleCompraModel();
        $carrito='';
        if (session()->get('ID_Rol') == null) {
            $usuario=0;
        }else{
            $usuario=session()->get('ID_Rol');
            $carrito=$detalleCompraModel->carritoProd(session()->get('ID'));
        }
        $data=['titulo'=>'Tienda','productos'=>$resultado,'categorias'=>$resultado2,'usuario'=>$usuario,'carrito'=>$carrito];
        return view('global/header',$data).view('global/tienda',$data) . view('global/footer');
    }

    public function contacto(): string
    {
        $detalleCompraModel= new DetalleCompraModel();
        $carrito='';
        if (session()->get('ID_Rol') == null) {
            $usuario=0;
        }else{
            $usuario=session()->get('ID_Rol');
            $carrito=$detalleCompraModel->carritoProd(session()->get('ID'));
        }
        $data=['titulo'=>'Contacto','carrito'=>$carrito];
        return view('global/header',$data).view('global/contacto') .view('global/footer');
    }

    public function comunidades(): string
    {   
        $comunidadModel = new ComunidadModel();
        $resultado = $comunidadModel->findAll();
        $detalleCompraModel= new DetalleCompraModel();
        $carrito='';
        if (session()->get('ID_Rol') == null) {
            $usuario=0;
        }else{
            $usuario=session()->get('ID_Rol');
            $carrito=$detalleCompraModel->carritoProd(session()->get('ID'));
        }
        $data=['titulo'=>'Comunidades','comunidad'=>$resultado,'carrito'=>$carrito];
        return view('global/header',$data).view('global/comunidades') .view('global/footer');
    }
    public function producto($idA,$idP): string
    {   
        $tieneProductoModel = new TieneProductoModel();
        $producto = $tieneProductoModel->getProducto($idA,$idP);
        $productoModel = new ProductoModel();
        $prod = $productoModel->find($idP);
        $prodR=$tieneProductoModel->prodRelacionados($idP);
        $detalleCompraModel= new DetalleCompraModel();
        $carrito='';
        if (session()->get('ID_Rol') == null) {
            $usuario=0;
        }else{
            $usuario=session()->get('ID_Rol');
            $carrito=$detalleCompraModel->carritoProd(session()->get('ID'));
        }
        $data=['titulo'=>'Producto','producto'=>$producto,'prod'=>$prod,'prodR'=>$prodR,'carrito'=>$carrito];
        return view('global/header',$data).view('global/producto') .view('global/footer');
    }
    public function carrito(): string
    {   
        $comunidadModel = new ComunidadModel();
        $resultado = $comunidadModel->findAll();
        $detalleCompraModel= new DetalleCompraModel();
        $carrito='';
        if (session()->get('ID_Rol') == null) {
            $usuario=0;
        }else{
            $usuario=session()->get('ID_Rol');
            $carrito=$detalleCompraModel->carritoProd(session()->get('ID'));
        }
        $data=['titulo'=>'Mi Carrito','comunidad'=>$resultado,'carrito'=>$carrito];
        return view('global/header',$data).view('global/carrito') .view('global/footer');
    }

    function anadirProd($idA,$idP,$cant,$precio){
        $tieneProductoModel = new TieneProductoModel();
        $detalleCompraModel= new DetalleCompraModel();
        $compraModel= new CompraModel();
        $prod=$tieneProductoModel->getProducto($idA,$idP);
        //  echo json_encode('productos');
        // $producto='hhhg';
        // echo 'nfkshdk';
        $rol=session()->get('ID_Rol');
        $idC=session()->get('ID');
        $dataC='';
        if ( $rol!=2) {
            //return json_encode('producto');
            // return json_encode(['status' => 'error', 'message' => 'Rol no autorizado']);
            return $this->response->setJSON(['status' => 0, 'ruta' => base_url('login')]);
        }else{
             $compra = $compraModel->verifCompra($idC);
            //  echo $compra;
             $idCompra='';
             if($compra!=null){
                $idCompra=$compra['ID'];
                $detalle=$detalleCompraModel->verifDetalle($idCompra,$idP,$idA);
                $dataC='';
                if($detalle!=null){
                    $data = [
                        'Cantidad'    => $detalle['Cantidad']+$cant,
                    ];
                    
                    $detalleCompraModel->actualizarDet($idCompra,$idP,$idA ,$data);
                    
                }else{
                    $dataC=[
                        'ID_Compra'=>$idCompra,
                        'ID_Producto'=>$idP,
                        'ID_Artesano'=>$idA,
                        'Cantidad'=>$cant,
                    ];
                    $idDet=$detalleCompraModel->insert($dataC);
                }
                $compra = $compraModel->update($idCompra,['Total'=>$compra['Total']+$cant*$precio]);

                $tieneProductoModel->actualizarProd($idA,$idP,['Stock'=>$prod['Stock']-$cant]);

             }else{
                $data=[
                    'Fecha'=>date('Y-m-d H:i:s'),
                    'Estado'=>'PENDIENTE',
                    'ID_Cliente'=>$idC,
                    'Total'=>$cant*$precio,
                ];
                $idCompra=$compraModel->insert($data);
                $dataC=[
                    'ID_Compra'=>$idCompra,
                    'ID_Producto'=>$idP,
                    'ID_Artesano'=>$idA,
                    'Cantidad'=>$cant,
                ];
                $idDet=$detalleCompraModel->insert($dataC);
             }
             
             
            $idDet='det';
            $carrito=$detalleCompraModel->carritoProd(session()->get('ID'));
        }
        return $this->response->setJSON(['status' => 1,$dataC,'det'=>$idDet,'carrito'=>$carrito]);
            
    }

    

}
