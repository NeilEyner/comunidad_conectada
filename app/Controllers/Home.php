<?php

namespace App\Controllers;
use App\Models\ContenidoModel;
use App\Models\ComunidadModel;
use App\Models\TieneProductoModel;
use App\Models\CategoriaModel;


class Home extends BaseController{

    public function index(): string
    {
        $tieneProductoModel = new TieneProductoModel();
        $resultado = $tieneProductoModel->findAll();
        $data=['titulo'=>'Comunidades','productos'=>$resultado];
        return view('global/header',$data).view('global/homeCarrusel').view('global/homeCategorias') .view('global/homeProducto'). view('global/footer');
    }

    public function nosotros(): string
    {
        $contenidoModel = new ContenidoModel();
        $resultado = $contenidoModel->findAll();
        
        $data=['titulo'=>'Nosotros','contenido'=>$resultado];
        return view('global/header',$data).view('global/nosotros',$data).view('global/servicios') .view('global/marcas'). view('global/footer');
    }

    public function tienda(): string
    {
        $tieneProductoModel = new TieneProductoModel();
        $resultado = $tieneProductoModel->findAll();
        $categoriaModel = new CategoriaModel();
        $resultado2 = $categoriaModel->findAll();
        $data=['titulo'=>'Comunidades','productos'=>$resultado,'categorias'=>$resultado2];
        return view('global/header',$data).view('global/tienda',$data) . view('global/footer');
    }

    public function contacto(): string
    {
        $data=['titulo'=>'Contacto'];
        return view('global/header',$data).view('global/contacto') .view('global/footer');
    }

    public function comunidades(): string
    {   
        $comunidadModel = new ComunidadModel();
        $resultado = $comunidadModel->findAll();
        $data=['titulo'=>'Comunidades','comunidad'=>$resultado];
        return view('global/header',$data).view('global/comunidades') .view('global/footer');
    }
}
