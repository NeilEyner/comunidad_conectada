<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data=['titulo'=>'Artesanias'];
        return view('global/header',$data).view('global/homeCarrusel').view('global/homeCategorias') .view('global/homeProducto'). view('global/footer');
    }

    public function nosotros(): string
    {
        $data=['titulo'=>'Nosotros'];
        return view('global/header',$data).view('global/nosotros').view('global/servicios') .view('global/marcas'). view('global/footer');
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
