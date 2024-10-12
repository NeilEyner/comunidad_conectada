<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\DetalleCompraModel;
use App\Models\CompraModel;
use App\Models\TieneproductoModel;

class CarritoController extends Controller{
    public function editarCarrito($idC, $idP, $idA,$precio,$cantidad){ 
        $detalleCompraModel= new DetalleCompraModel();
        $compraModel=new CompraModel();
        $cant=$detalleCompraModel->encontrar($idC,$idP,$idA)['Cantidad'];

        $detalleCompraModel->actualizarDet($idC,$idP,$idA,['Cantidad' => $cantidad]);

        $total=$compraModel->find($idC)['Total'];
        if($cant>$cantidad){
            $total=$total-($cant-$cantidad)*$precio;
        }else{
            $total=$total+($cantidad-$cant)*$precio;
        }
        $compraModel->ActualizarCompra($idC,['Total' => $total]);

        $carrito= $detalleCompraModel->carritoUnProd(session()->get('ID'),$idA,$idP);
        return $this->response->setJSON(['carrito'=>$carrito,'total'=>$total,'cant'=>$cant,'cantidad'=>$cantidad]);
    }

    public function eliminarProd(){
        $detalleCompraModel= new DetalleCompraModel();
        $compraModel=new CompraModel();
        $tieneProductoModel=new TieneProductoModel();
        $idC=$this->request->getVar('idC');
        $idP=$this->request->getVar('idP');
        $idA=$this->request->getVar('idA');
        $detalle=$detalleCompraModel->encontrar($idC,$idP,$idA);
        $total=$compraModel->find($idC)['Total'];
        $precio=$tieneProductoModel->getProducto($idA,$idP)['Precio'];
        $total=$total-($detalle['Cantidad']*$precio);
        $compraModel->ActualizarCompra($idC,['Total' => $total]);
        $detalleCompraModel->eliminar($idC,$idP,$idA);
        $stock=$tieneProductoModel->getProducto($idA,$idP)['Stock'];
        $tieneProductoModel->actualizarProd($idA,$idP,['Stock' => $stock+$detalle['Cantidad']]);
        $carrito= $detalleCompraModel->carritoUnProd(session()->get('ID'),$idA,$idP);
        return $this->response->setJSON(['carrito'=>$carrito,'total'=>$total,'idC'=>$idC,'idP'=>$idP,'idA'=>$idA]);
        //  return $this->response->setJSON(['total'=>$total,'detalle'=>$detalle]);
    }
}

?>