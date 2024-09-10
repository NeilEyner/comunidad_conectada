<?php

namespace App\Controllers;
use App\Models\ContenidoModel;


class Home extends BaseController
{
    public function index(): string
    {
        $data=['titulo'=>'Inicio'];
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
        $data=['titulo'=>'Tienda'];
        return view('global/header',$data).view('global/tienda') .view('global/marcas'). view('global/footer');
    }

    public function contacto(): string
    {
        $data=['titulo'=>'Contacto'];
        return view('global/header',$data).view('global/contacto') .view('global/footer');
    }

    public function comunidades(): string
    {
        $data=['titulo'=>'Comunidades'];
        return view('global/header',$data).view('global/comunidades') .view('global/footer');
    }
}
