<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\DetalleCompraModel;
use App\Models\CompraModel;
use App\Models\TieneproductoModel;

class CarritoController extends Controller{
    public function editarCarrito($idC, $idP, $idA,$precio,$dif){ 
        $detalleCompraModel= new DetalleCompraModel();
        $tieneProductoModel=new TieneProductoModel();
        $compraModel=new CompraModel();
        $cant=$detalleCompraModel->encontrar($idC,$idP,$idA)['Cantidad'];

        // $detalleCompraModel->actualizarDet($idC,$idP,$idA,['Cantidad' => $cantidad]);
        $stock=$tieneProductoModel->getProducto($idA,$idP)['Stock'];
        $total=$compraModel->find($idC)['Total'];
        // if($cant>$cantidad){
        //     $total=$total-($cant-$cantidad)*$precio;
        // }else{
        //     $total=$total+($cantidad-$cant)*$precio;
        // }

        //-----------
        $detalleCompraModel->actualizarDet($idC,$idP,$idA,['Cantidad' => $cant+$dif]);
        $total=$total+$dif*$precio;
        $stock=$stock-$dif;

        //-------------------
        $compraModel->ActualizarCompra($idC,['Total' => $total]);
        $tieneProductoModel->actualizarProd($idA,$idP,['Stock'=>$stock]);

        $carrito= $detalleCompraModel->carritoUnProd(session()->get('ID'),$idA,$idP);
        return $this->response->setJSON(['carrito'=>$carrito,'total'=>$total,'cant'=>$cant,'cantidad'=>$cant+$dif]);
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
        $cantProd=$detalleCompraModel->where('ID_Compra',$idC)->findAll();
        return $this->response->setJSON(['carrito'=>$carrito,'total'=>$total,'idC'=>$idC,'idP'=>$idP,'idA'=>$idA,'cantProd'=>sizeof($cantProd)]);
        //  return $this->response->setJSON(['total'=>$total,'detalle'=>$detalle]);
    }
}

?>