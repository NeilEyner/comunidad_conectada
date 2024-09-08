<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuarioModel;
use App\Models\ComunidadModel;

class DashboardController extends Controller
{
    public function artesano()
    {
        // if (session()->get('ID_Rol') != 1) {
        //     return redirect()->to(base_url('login'));
        // }
        $data=['titulo'=>'Artesano'];
        return view('dashboard/header',$data).view('dashboard/artesano');
    }

    public function cliente()
    {
        // if (session()->get('ID_Rol') != 2) {
        //     return redirect()->to(base_url('login'));
        // }
        $data=['titulo'=>'Cliente'];
        return view('dashboard/header',$data).view('dashboard/cliente');
    }

    public function delivery()
    {
        // if (session()->get('ID_Rol') != 3) {
        //     return redirect()->to(base_url('login'));
        // }
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

        return view('dashboard/admin', $data);
    }
    public function admin_user()
    {
        $model = new UsuarioModel();
        $data['usuarios'] = $model->findAll(); // Obtén todos los usuarios

        return view('dashboard/admin_usuario', $data);
    }
    public function admin_comunidad(){
        $model = new ComunidadModel();
        $data['comunidades'] = $model->findAll(); // Obtén todas las comunidades
        return view('dashboard/admin_comunidad', $data);
    }
}