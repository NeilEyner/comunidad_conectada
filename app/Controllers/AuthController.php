<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\RolModel;
use App\Models\ComunidadModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    protected $usuarioModel;
    protected $rolModel;
    protected $comunidadModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->rolModel = new RolModel();
        $this->comunidadModel = new ComunidadModel();
    }

    public function register()
    {

        $data['roles'] = $this->rolModel->findAll();
        $data['comunidades'] = $this->comunidadModel->findAll();

        return view('auth/register', $data);
    }
    public function do_register()
    {
        helper(['form']);
        
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'Nombre' => 'required|min_length[3]|max_length[50]',
                'Correo_electronico' => 'required|valid_email|is_unique[USUARIO.Correo_electronico]',
                'Telefono' => 'required|numeric|min_length[4]',
                'Contrasena' => 'required|min_length[3]',
                'ID_Rol' => 'required|integer',
                'Direccion' => 'required',
                'ID_Comunidad' => 'required|integer'
            ];

            if ($this->validate($rules)) {
                $hasheadoContrasena = $this->request->getPost('Contrasena');

                $data = [
                    'Nombre' => $this->request->getPost('Nombre'),
                    'Correo_electronico' => $this->request->getPost('Correo_electronico'),
                    'Telefono' => $this->request->getPost('Telefono'),
                    'Contrasena' => $hasheadoContrasena,
                    'ID_Rol' => $this->request->getPost('ID_Rol'),
                    'Direccion' => $this->request->getPost('Direccion'),
                    'ID_Comunidad' => $this->request->getPost('ID_Comunidad'),
                    'Estado' => 'INACTIVO'
                ];

                if ($this->usuarioModel->insert($data)) {
                    return redirect()->to(base_url('login'))->with('success', 'Usuario registrado exitosamente');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Ocurrió un error al registrar el usuario');
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

    }

    public function login()
    {
        return view('auth/login');
    }
    public function do_login()
    {
        helper(['form']);
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'Correo_electronico' => 'required|valid_email',
                'Contrasena' => 'required'
            ];
            if ($this->validate($rules)) {
                $correo = $this->request->getPost('Correo_electronico');
                $contrasena = $this->request->getPost('Contrasena');
                $usuario = $this->usuarioModel->where('Correo_electronico', $correo)->first();
                if (password_verify($contrasena, $usuario['Contrasena'])) {
                    if ($usuario['Estado'] !== 'ACTIVO') {
                        return redirect()->back()->with('error', 'Tu cuenta no está activa. Por favor, contacta al administrador.');
                    }
                    $this->setUserSession($usuario);
                    return $this->redirectBasedOnRole($usuario['ID_Rol']);
                } else {
                    return redirect()->back()->withInput()->with('error', 'Correo electrónico o contraseña incorrectos');
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }
    }
    
    protected function setUserSession($usuario)
    {
        $data = [
            'ID' => $usuario['ID'],
            'Nombre' => $usuario['Nombre'],
            'ID_Rol' => $usuario['ID_Rol'],
            'isLoggedIn' => true,
        ];

        session()->set($data);
        return true;
    }

    protected function redirectBasedOnRole($rolId)
    {
        switch ($rolId) {
            case 1: // Artesano
                return redirect()->to(base_url('dashboard/artesano'));
            case 2: // Cliente
                return redirect()->to(base_url('dashboard/cliente'));
            case 3: // Delivery
                return redirect()->to(base_url('dashboard/delivery'));
            case 4: // Administrador
                return redirect()->to(base_url('dashboard/admin'));
            default:
                return redirect()->to(base_url('dashboard'));
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('success', 'Has cerrado sesión exitosamente');
    }
}