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
    public function do_registerR()
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
                'ID_Comunidad' => 'required|integer',

            ];

            if ($this->validate($rules)) {
                $imagen = $this->request->getFile('imagen');
                if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
                    // Generar un nombre único para la imagen
                    $nombreImagen = $imagen->getRandomName();
                    // Mover la imagen a la carpeta 'uploads'
                    $imagen->move(FCPATH . 'images/avatar/', $nombreImagen);
                    // Guardar la URL de la imagen
                    $imagenURL = base_url('images/avatar/' . $nombreImagen);
                } else {
                    $imagenURL = base_url('images/avatar/ava.png');
                    ;
                }

                $hasheadoContrasena = $this->request->getPost('Contrasena');

                $data = [
                    'Nombre' => $this->request->getPost('Nombre'),
                    'Correo_electronico' => $this->request->getPost('Correo_electronico'),
                    'Telefono' => $this->request->getPost('Telefono'),
                    'Contrasena' => $hasheadoContrasena,
                    'ID_Rol' => $this->request->getPost('ID_Rol'),
                    'Direccion' => $this->request->getPost('Direccion'),
                    'ID_Comunidad' => $this->request->getPost('ID_Comunidad'),
                    'Imagen_URL' => $imagenURL,
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
    public function do_register()
    {
        helper(['form']);
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'Nombre' => 'required|min_length[3]|max_length[50]',
                'Correo_electronico' => 'required|valid_email|is_unique[USUARIO.Correo_electronico]',
                'Contrasena' => 'required|min_length[3]',
                'Confirmar_Contrasena' => 'required|matches[Contrasena]',
                'ID_Rol' => 'permit_empty|integer',
                'ID_Comunidad' => 'permit_empty|integer'
            ];

            if ($this->validate($rules)) {
                $imagenURL = base_url('images/avatar/ava.png');
                $data = [
                    'Nombre' => $this->request->getPost('Nombre'),
                    'Correo_electronico' => $this->request->getPost('Correo_electronico'),
                    'Contrasena' => $this->request->getPost('Contrasena'),
                    'ID_Rol' => $this->request->getPost('ID_Rol') ?: null,
                    'ID_Comunidad' => $this->request->getPost('ID_Comunidad') ?: null,
                    'Imagen_URL' => $imagenURL,
                    'Estado' => 'INACTIVO'
                ];
                if ($this->usuarioModel->insert($data)) {
                    return redirect()->to(base_url('login'))->with('success', 'Usuario registrado exitosamente');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Ocurrió un error al registrar el usuario');
                }
            } else {

                return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
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

                // Buscar el usuario por correo electrónico
                $usuario = $this->usuarioModel->where('Correo_electronico', $correo)->first();

                if ($usuario) {
                    // Verificar la contraseña si el usuario existe
                    if (password_verify($contrasena, $usuario['Contrasena'])) {
                        // Verificar el estado del usuario
                        if ($usuario['Estado'] !== 'ACTIVO') {
                            return redirect()->back()->with('error', 'Tu cuenta no está activa. Por favor, contacta al administrador.');
                        }

                        // Establecer sesión del usuario y redirigir según su rol
                        $this->setUserSession($usuario);
                        return $this->redirectBasedOnRole($usuario['ID_Rol']);
                    } else {
                        // Contraseña incorrecta
                        return redirect()->back()->withInput()->with('error', 'contraseña incorrectos');
                    }
                } else {
                    // Correo electrónico no registrado
                    return redirect()->back()->withInput()->with('error', 'Correo electrónico');
                }
            } else {
                // Error en la validación
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
            'Imagen_URL' => $usuario['Imagen_URL'],
            'isLoggedIn' => true,
        ];

        session()->set($data);
        return true;
    }
    protected function redirectBasedOnRole($rolId)
    {
        return redirect()->to(base_url());
        // switch ($rolId) {
        //     case 1: // Artesano
        //         return redirect()->to(base_url());
        //     case 2: // Cliente
        //         return redirect()->to(base_url('dashboard/cliente/cli_dashboard'));
        //     case 3: // Delivery
        //         return redirect()->to(base_url('dashboard/delivery/deli_dashboard'));
        //     case 4: // Administrador
        //         return redirect()->to(base_url('dashboard/administrador/admin_dashboard'));
        //     default:
        //         return redirect()->to(base_url());
        // }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url())->with('success', 'Has cerrado sesión exitosamente');
    }
    public function perfil($ID){
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($ID);
        return view('auth/perfil', ['usuario' => $usuario]);

    }
    public function do_update($id)
    {
        $model = new UsuarioModel();
        helper(['form', 'url']); // Agregado 'url' helper para usar base_url()
    
        // Buscar el usuario
        $usuario = $model->find($id);
        if (!$usuario) {
            return redirect()->back()->with('message', 'Usuario no encontrado.')->withInput();
        }
    
        // Reglas de validación
        $rules = [
            'Nombre' => 'required|min_length[3]',
            'Correo_electronico' => 'required|valid_email',
            'Telefono' => 'permit_empty'
        ];
    
        // Validar la entrada
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        // Manejo de la imagen
        $imagen = $this->request->getFile('Imagen_URL');
        $imagenURL = null;
    
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(FCPATH . 'images/avatar/', $nombreImagen);
            $imagenURL = base_url('images/avatar/' . $nombreImagen);
        }
    
        // Construir los datos para actualizar
        $data = [
            'Nombre' => $this->request->getPost('Nombre'),
            'Correo_electronico' => $this->request->getPost('Correo_electronico'),
            'Telefono' => $this->request->getPost('Telefono') ?: null,
            'Direccion' => $this->request->getPost('Direccion') ?: null,
            'ID_Comunidad' => $this->request->getPost('ID_Comunidad') ?: null,
        ];
    
        // Si se subió una imagen, actualizar la URL de la imagen
        if ($imagenURL) {
            $data['Imagen_URL'] = $imagenURL;
        }
    
        // Si se proporcionó una contraseña, encriptarla antes de guardar
        if ($this->request->getPost('Contrasena')) {
            $data['Contrasena'] = $this->request->getPost('Contrasena');
        }
    
        // Actualizar el usuario
        if ($model->update($id, $data)) {
            return redirect()->back()->with('message', 'Usuario actualizado correctamente.');
        } else {
            return redirect()->back()->with('message', 'Ocurrió un error al actualizar el usuario.')->withInput();
        }
    }
    
    
    


}