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

class AdministradorController extends Controller
{
    public function artesano()
    {
        if (session()->get('ID_Rol') != 1) {
            return redirect()->to(base_url('login'));
        }
        $data=['titulo'=>'Artesano'];
        return view('dashboard/header',$data).view('dashboard/artesano');
    }

    public function cliente()
    {
        if (session()->get('ID_Rol') != 2) {
            return redirect()->to(base_url('login'));
        }
        $data=['titulo'=>'Cliente'];
        return view('dashboard/header',$data).view('dashboard/cliente');
    }

    public function delivery()
    {
        if (session()->get('ID_Rol') != 3) {
            return redirect()->to(base_url('login'));
        }
        $data=['titulo'=>'Delivery'];
        return view('dashboard/header',$data).view('dashboard/delivery');
    }



    public function admin()
    {
        if (session()->get('ID_Rol') != 4) {
            return redirect()->to(base_url('login'));
        }
        $model = new UsuarioModel();
        $data['usuarios'] = $model->findAll();
        return view('dashboard/administrador/admin_dashboard', $data);
    }
    public function admin_user()
    {
        $model = new UsuarioModel();
        $data['usuarios'] = $model->findAll();
        return view('dashboard/administrador/admin_usuario', $data);
    }
    public function admin_comunidad(){
        $model = new ComunidadModel();
        $data['comunidades'] = $model->findAll(); 
        return view('dashboard/administrador/admin_comunidad', $data);
    }

    public function admin_rol(){
        $model = new RolModel();
        $data['roles'] = $model->findAll(); 
        return view('dashboard/administrador/admin_rol', $data);
    }
    public function admin_contenidopagina(){
        $model = new ContenidoPaginaModel();
        $data['contenido_pagina'] = $model->findAll(); 
        return view('dashboard/administrador/admin_contenidopagina', $data);
    }
    public function admin_envio(){
        $model = new EnvioModel();
        $data['envios'] = $model->findAll(); 
        return view('dashboard/administrador/admin_envio', $data);
    }
    public function admin_pago(){
        $model = new PagoModel();
        $data['pagos'] = $model->findAll(); 
        return view('dashboard/administrador/admin_pago', $data);
    }
    public function admin_producto(){
        $model = new ProductoModel();
        $data['productos'] = $model->findAll(); 
        return view('dashboard/administrador/admin_producto', $data);
    }
    public function admin_compra(){
        $model = new CompraModel();
        $data['compras'] = $model->findAll(); 
        return view('dashboard/administrador/admin_compra', $data);
    }
}