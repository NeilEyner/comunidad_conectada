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
use App\Models\TieneProductoModel;
use App\Models\DetalleCompraModel;
use App\Models\TransporteModel;


class AdministradorController extends Controller
{

    public function artesano()
    {
        if (session()->get('ID_Rol') != 1) {
            return redirect()->to(base_url('login'));
        }
        $data = ['titulo' => 'Artesano'];
        return view('dashboard/header', $data) . view('dashboard/artesano');
    }

    public function cliente()
    {
        if (session()->get('ID_Rol') != 2) {
            return redirect()->to(base_url('login'));
        }
        $data = ['titulo' => 'Cliente'];
        return view('dashboard/header', $data) . view('dashboard/cliente');
    }

    public function delivery()
    {
        if (session()->get('ID_Rol') != 3) {
            return redirect()->to(base_url('login'));
        }
        $data = ['titulo' => 'Delivery'];
        return view('dashboard/header', $data) . view('dashboard/delivery');
    }
    //  ADMINISTRADOR USUARIOS
    public function admin()
    {
        if (session()->get('ID_Rol') != 4) {
            return redirect()->to(base_url('login'));
        }
        $model = new UsuarioModel();
        $data['usuarios'] = $model->findAll();
        return view('dashboard/administrador/admin_dashboard', $data);
    }

    // ADMINISTRADOR USUARIO
    public function admin_user()
    {
        $model = new UsuarioModel();
        $rolModel = new RolModel();
        $comunidadModel = new ComunidadModel();
        $data['usuarios'] = $model->findAll();
        $data['roles'] = $rolModel->findAll();
        $data['comunidades'] = $comunidadModel->findAll();
        return view('dashboard/administrador/admin_usuario', $data);
    }
    public function admin_editar_usuario($id)
    {
        $model = new UsuarioModel();
        helper(['form']);
        $usuario = $model->find($id);

        if (!$usuario) {
            return redirect()->back()->with('message', 'Usuario no encontrado.');
        }
        $rules = [
            'Nombre' => 'required|min_length[3]',
            'Correo_electronico' => 'required|valid_email',
            'Telefono' => 'permit_empty|required',
            'ID_Rol' => 'required',
            'Estado' => 'required'
        ];
        $imagen = $this->request->getFile('Imagen_URL');

        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(FCPATH . 'images/avatar/', $nombreImagen);
            $imagenURL = base_url('images/avatar/' . $nombreImagen);
        }
        $data = [
            'Nombre' => $this->request->getPost('Nombre'),
            'Correo_electronico' => $this->request->getPost('Correo_electronico'),
            'Telefono' => $this->request->getPost('Telefono') ?: null,
            'ID_Rol' => $this->request->getPost('ID_Rol'),
            'Direccion' => $this->request->getPost('Direccion') ?: null,
            'Estado' => $this->request->getPost('Estado'),
            'ID_Comunidad' => $this->request->getPost('ID_Comunidad') ?: null,
        ];
        if (isset($imagenURL)) {
            $data['Imagen_URL'] = $imagenURL;
        }
        if ($this->request->getPost('Contrasena')) {
            $data['Contrasena'] = $this->request->getPost('Contrasena');
        }
        $model->update($id, $data);

        return redirect()->to(base_url('dashboard/administrador/admin_usuarios'))->with('message', 'Usuario actualizado correctamente.');
    }
    public function admin_agregar_usuario()
    {
        helper(['form']);
        $usuarioModel = new UsuarioModel();
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
                    $nombreImagen = $imagen->getRandomName();
                    $imagen->move(FCPATH . 'images/avatar/', $nombreImagen);
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
                if ($usuarioModel->insert($data)) {
                    return redirect()->to(base_url('dashboard/administrador/admin_usuarios'))->with('success', 'Usuario registrado exitosamente');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Ocurrió un error al registrar el usuario');
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

    }
    public function admin_eliminar_usuario($id)
    {
        $model = new UsuarioModel();
        if ($model->find($id)) {
            $model->delete($id);
            return redirect()->back()->with('message', 'Usuario eliminado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }
    }

    //ADMINISTRADOR COMUNIDAD

    public function admin_comunidad()
    {
        $model = new ComunidadModel();
        $data['comunidades'] = $model->findAll();
        return view('dashboard/administrador/admin_comunidad', $data);
    }
    public function admin_agregar_comunidad()
    {
        helper(['form']);
        $model = new ComunidadModel();

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'Nombre' => 'required|min_length[3]|max_length[100]',
                'Descripcion' => 'required',
                'Ubicacion' => 'required'
            ];

            if ($this->validate($rules)) {
                $data = [
                    'Nombre' => $this->request->getPost('Nombre'),
                    'Descripcion' => $this->request->getPost('Descripcion'),
                    'Ubicacion' => $this->request->getPost('Ubicacion'),
                    'Latitud' => $this->request->getPost('Latitud'),
                    'Longitud' => $this->request->getPost('Longitud')
                ];
                $model->insert($data);
                return redirect()->back()->with('errors', 'Comunidad agregada correctamente.');
            }
        }
        return redirect()->back();
    }
    public function admin_editar_comunidad($id)
    {
        $model = new ComunidadModel();
        $comunidad = $model->find($id);

        if (!$comunidad) {
            return redirect()->back()->with('message', 'Comunidad no encontrada.');
        }

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'Nombre' => 'required|min_length[3]|max_length[100]',
                'Descripcion' => 'required',
                'Ubicacion' => 'required',
                'Latitud' => 'permit_empty|decimal',
                'Longitud' => 'permit_empty|decimal'
            ];

            if ($this->validate($rules)) {
                // Manejar valores vacíos para latitud y longitud
                $latitud = $this->request->getPost('Latitud');
                $longitud = $this->request->getPost('Longitud');

                $data = [
                    'Nombre' => $this->request->getPost('Nombre'),
                    'Descripcion' => $this->request->getPost('Descripcion'),
                    'Ubicacion' => $this->request->getPost('Ubicacion'),
                    'Latitud' => $latitud ? $latitud : null,
                    'Longitud' => $longitud ? $longitud : null,
                ];

                if ($model->update($id, $data)) {
                    return redirect()->to(base_url('dashboard/administrador/admin_comunidades'))->with('message', 'Comunidad editada correctamente.');
                } else {
                    // Captura y muestra el error de la base de datos
                    $db = \Config\Database::connect();
                    $model->update($id, $data);
                    echo $db->getLastQuery();  // Imprime la consulta SQL generada

                    return redirect()->back()->with('errors', 'Error al actualizar la comunidad: ' . $db->getLastQuery());
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        return redirect()->back();
    }
    public function admin_eliminar_comunidad($id)
    {
        $model = new ComunidadModel();
        if ($model->find($id)) {
            $model->delete($id);
            return redirect()->back()->with('errors', 'Comunidad eliminado correctamente.');
        } else {
            return redirect()->back()->with('errors', 'Comunidad no encontrado.');
        }
    }

    // ADMINISTRADOR ROL
    public function admin_rol()
    {
        $model = new RolModel();
        $data['roles'] = $model->findAll();
        return view('dashboard/administrador/admin_rol', $data);
    }

    public function admin_agregar_rol()
    {
        helper(['form']);
        $model = new RolModel();

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'Nombre' => 'required|min_length[3]|max_length[50]',
                'Descripcion' => 'required'
            ];

            if ($this->validate($rules)) {
                $data = [
                    'Nombre' => $this->request->getPost('Nombre'),
                    'Descripcion' => $this->request->getPost('Descripcion')
                ];
                $model->insert($data);
                return redirect()->back()->with('message', 'Agregado correctamente.');
            }
        }
        return redirect()->back();
    }

    public function admin_editar_rol($id)
    {
        $model = new RolModel();
        $rol = $model->find($id);

        if (!$rol) {
            return redirect()->back()->with('message', 'No encontrado.');
        }

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'Nombre' => 'required|min_length[3]|max_length[50]',
                'Descripcion' => 'required'
            ];

            if ($this->validate($rules)) {
                $data = [
                    'Nombre' => $this->request->getPost('Nombre'),
                    'Descripcion' => $this->request->getPost('Descripcion')
                ];
                $model->update($id, $data);
                return redirect()->to(base_url('dashboard/administrador/admin_rol'))->with('message', 'Rol actualizado correctamente.');
            }
        }
        return redirect()->back();
    }

    public function admin_eliminar_rol($id)
    {
        $model = new RolModel();
        if ($model->find($id)) {
            $model->delete($id);
            return redirect()->back()->with('message', 'Eliminado correctamente.');
        } else {
            return redirect()->back()->with('message', 'No encontrado.');
        }
    }

    // ADMINISTRADOR CONTENIDO DE PÁGINA
    public function admin_contenidopagina()
    {
        $model = new ContenidoPaginaModel();
        $data['contenido_pagina'] = $model->findAll();
        return view('dashboard/administrador/admin_contenidopagina', $data);
    }

    public function admin_agregar_contenido_pagina()
    {
        helper(['form']);
        $model = new ContenidoPaginaModel();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'Tipo_contenido' => 'required',
                'Titulo' => 'required|max_length[255]',
                'Contenido' => 'required',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'Tipo_contenido' => $this->request->getPost('Tipo_contenido'),
                    'Titulo' => $this->request->getPost('Titulo'),
                    'Contenido' => $this->request->getPost('Contenido'),
                    'ID_Usuario' => session()->get('ID'),
                ];

                if ($model->insert($data)) {
                    return redirect()->back()->with('message', 'Agregado correctamente.');
                } else {
                    return redirect()->back()->with('error', 'Error al agregar el contenido.');
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }
        return redirect()->back();
    }

    public function admin_editar_contenido_pagina($id)
    {
        helper(['form']);
        $model = new ContenidoPaginaModel();
        $contenido = $model->find($id);
        if (!$contenido) {
            return redirect()->back();
        }
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'Titulo' => 'required|max_length[255]',
                'Contenido' => 'required',
            ];
            if ($this->validate($rules)) {
                $data = [
                    'Titulo' => $this->request->getPost('Titulo'),
                    'Contenido' => $this->request->getPost('Contenido'),
                    'Fecha_actualizacion' => date('Y-m-d H:i:s')
                ];
                $model->update($id, $data);
                return redirect()->to(base_url('dashboard/administrador/admin_contenidopagina'));
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }
        // return redirect()->back();
    }

    public function admin_eliminar_contenido_pagina($id)
    {
        $model = new ContenidoPaginaModel();
        if ($model->find($id)) {
            $model->delete($id);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
    // ADMINISTRADOR ENVÍO
    public function admin_envio()
    {
        $model = new EnvioModel();
        $data['envios'] = $model->findAll();
        return view('dashboard/administrador/admin_envio', $data);
    }
    public function admin_agregar_envio()
    {
        helper(['form']);
        $model = new EnvioModel();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'ID_Compra' => 'required|integer',
                'Direccion_Destino' => 'required',
                'Fecha_Envio' => 'required|valid_date',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'ID_Compra' => $this->request->getPost('ID_Compra'),
                    'Direccion_Destino' => $this->request->getPost('Direccion_Destino'),
                    'Fecha_Envio' => $this->request->getPost('Fecha_Envio'),
                    'Estado' => 'PREPARANDO',
                ];

                if ($model->insert($data)) {
                    return redirect()->to(base_url('dashboard/administrador/admin_envio'))->with('success', 'Envío agregado correctamente.');
                } else {
                    return redirect()->back()->with('error', 'Error al agregar el envío.');
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        return view('dashboard/administrador/admin_agregar_envio');
    }
    public function admin_editar_envio($id)
    {
        helper(['form']);
        $model = new EnvioModel();
        $envio = $model->find($id);

        if (!$envio) {
            return redirect()->to(base_url('dashboard/administrador/admin_envio'))->with('error', 'Envío no encontrado.');
        }

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'ID_Compra' => 'required|integer',
                'Direccion_Destino' => 'required',
                'Fecha_Envio' => 'required|valid_date',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'ID_Compra' => $this->request->getPost('ID_Compra'),
                    'Direccion_Destino' => $this->request->getPost('Direccion_Destino'),
                    'Fecha_Envio' => $this->request->getPost('Fecha_Envio'),
                    'Estado' => $this->request->getPost('Estado'),
                ];

                $model->update($id, $data);
                return redirect()->to(base_url('dashboard/administrador/admin_envio'))->with('success', 'Envío actualizado correctamente.');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        $data['envio'] = $envio;
        return view('dashboard/administrador/admin_editar_envio', $data);
    }

    public function admin_eliminar_envio($id)
    {
        $model = new EnvioModel();
        if ($model->find($id)) {
            $model->delete($id);
            return redirect()->to(base_url('dashboard/administrador/admin_envio'))->with('message', 'Envío eliminado correctamente.');
        } else {
            return redirect()->to(base_url('dashboard/administrador/admin_envio'))->with('error', 'Envío no encontrado.');
        }
    }

    // ADMINISTRADOR PAGO
    public function admin_pago()
    {
        $pagoModel = new PagoModel();
        $compraModel = new CompraModel();
        $detalleCompraModel = new DetalleCompraModel();
        $usuarioModel = new UsuarioModel();
        $productoModel = new ProductoModel();

        // Obtener la lista de todos los pagos
        $pagos = $pagoModel->findAll();

        // Recorrer los pagos para obtener detalles adicionales (compra, cliente y detalle de productos)
        foreach ($pagos as &$pago) {
            // Obtener datos de la compra relacionada
            $compra = $compraModel->where('ID', $pago['ID_Compra'])->first();
            $pago['compra'] = $compra;

            // Obtener los detalles de la compra
            $detalleCompra = $detalleCompraModel->where('ID_Compra', $pago['ID_Compra'])->findAll();
            $pago['detalle_compra'] = [];

            // Obtener los detalles de productos y artesanos para cada detalle de compra
            foreach ($detalleCompra as $detalle) {
                $producto = $productoModel->where('ID', $detalle['ID_Producto'])->first();
                $artesano = $usuarioModel->where('ID', $detalle['ID_Artesano'])->first();

                $detalle['producto'] = $producto;
                $detalle['artesano'] = $artesano;

                $pago['detalle_compra'][] = $detalle;
            }

            // Obtener el cliente que realizó la compra
            $cliente = $usuarioModel->where('ID', $pago['ID_Cliente'])->first();
            $pago['cliente'] = $cliente;
        }

        return view('dashboard/administrador/admin_pago', ['pagos' => $pagos]);
    }

    public function admin_agregar_pago()
    {
        helper(['form']);
        $model = new PagoModel();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'ID_Compra' => 'required|integer',
                'Monto' => 'required|numeric',
                'Fecha_Pago' => 'required|valid_date',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'ID_Compra' => $this->request->getPost('ID_Compra'),
                    'Monto' => $this->request->getPost('Monto'),
                    'Fecha_Pago' => $this->request->getPost('Fecha_Pago'),
                    'Metodo_Pago' => $this->request->getPost('Metodo_Pago'),
                ];

                if ($model->insert($data)) {
                    return redirect()->back();
                } else {
                    return redirect()->back();
                }
            } else {
                return redirect()->back();
            }
        }

        return view('dashboard/administrador/admin_agregar_pago');
    }

    public function admin_editar_pago($id)
    {
        helper(['form']);
        $model = new PagoModel();
        $pago = $model->find($id);

        if (!$pago) {
            return redirect()->to(base_url('dashboard/administrador/admin_pago'))->with('error', 'Pago no encontrado.');
        }

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'ID_Compra' => 'required|integer',
                'Monto' => 'required|numeric',
                'Fecha_Pago' => 'required|valid_date',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'ID_Compra' => $this->request->getPost('ID_Compra'),
                    'Monto' => $this->request->getPost('Monto'),
                    'Fecha_Pago' => $this->request->getPost('Fecha_Pago'),
                    'Metodo_Pago' => $this->request->getPost('Metodo_Pago'),
                ];

                $model->update($id, $data);
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        }

        $data['pago'] = $pago;
        return view('dashboard/administrador/admin_editar_pago', $data);
    }

    public function admin_eliminar_pago($id)
    {
        $model = new PagoModel();
        if ($model->find($id)) {
            $model->delete($id);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
    public function verificar_pago($id_pago)
    {
        $pagoModel = new PagoModel();
        $pago = $pagoModel->find($id_pago);

        // Aquí el administrador puede cambiar el estado del pago a "COMPLETADO" o "FALLIDO"
        if ($this->request->getMethod() === 'post') {
            $estado = $this->request->getPost('estado');
            $pagoModel->update($id_pago, ['Estado' => $estado]);
            return redirect()->to('/admin/pagos')->with('success', 'Pago actualizado');
        }

        return view('admin/verificar_pago', ['pago' => $pago]);
    }

    // ADMINISTRADOR PRODUCTO
    public function admin_producto()
    {
        $model = new ProductoModel();
        $data['productos'] = $model->findAll();
        return view('dashboard/administrador/admin_producto', $data);
    }

    public function admin_agregar_producto()
    {
        helper(['form']);
        $model = new ProductoModel();

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'Nombre' => 'required|max_length[255]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'Nombre' => $this->request->getPost('Nombre'),
                ];

                if ($model->insert($data)) {
                    return redirect()->to(base_url('dashboard/administrador/admin_producto'))->with('message', 'prod agregado correctamente.');

                } else {
                    return redirect()->to(base_url('dashboard/administrador/admin_producto'))->with('message', 'prod agregado correctamente.');

                }
            } else {
                return redirect()->to(base_url('dashboard/administrador/admin_producto'))->with('message', 'prod agregado correctamente.');

            }
        }

        return redirect()->to(base_url('dashboard/administrador/admin_producto'))->with('message', 'prod agregado correctamente.');
    }

    public function admin_editar_producto($id)
    {
        helper(['form']);
        $model = new ProductoModel();
        $producto = $model->find($id);

        if (!$producto) {
            return redirect()->back();
        }

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'Nombre' => 'required|max_length[255]',
                'Descripcion' => 'required',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'Nombre' => $this->request->getPost('Nombre'),
                ];

                $model->update($id, $data);
                return redirect()->to(base_url('dashboard/administrador/admin_producto'))->with('message', 'prod agregado correctamente.');

            } else {
                return redirect()->to(base_url('dashboard/administrador/admin_producto'))->with('message', 'prod agregado correctamente.');

            }
        }

        return redirect()->to(base_url('dashboard/administrador/admin_producto'))->with('message', 'prod actualizado correctamente.');
    }

    public function admin_eliminar_producto($id)
    {
        $model = new ProductoModel();
        if ($model->find($id)) {
            $model->delete($id);
        }
        return redirect()->to(base_url('dashboard/administrador/admin_producto'))->with('message', 'prod agregado correctamente.');

    }

    // ADMINISTRADOR COMPRA
    public function admin_compra()
    {
        $model = new CompraModel();
        $data['compras'] = $model->findAll();
        return view('dashboard/administrador/admin_compra', $data);
    }

    public function admin_agregar_compra()
    {
        helper(['form']);
        $model = new CompraModel();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'ID_Usuario' => 'required|integer',
                'Total' => 'required|numeric',
                'Fecha_Compra' => 'required|valid_date',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'ID_Usuario' => $this->request->getPost('ID_Usuario'),
                    'Total' => $this->request->getPost('Total'),
                    'Fecha_Compra' => $this->request->getPost('Fecha_Compra'),
                    'Estado' => $this->request->getPost('Estado'),
                ];

                if ($model->insert($data)) {
                    return redirect()->back();
                } else {
                    return redirect()->back();
                }
            } else {
                return redirect()->back();
            }
        }
        return view('dashboard/administrador/admin_agregar_compra');
    }

    public function admin_editar_compra($id)
    {
        helper(['form']);
        $model = new CompraModel();
        $compra = $model->find($id);

        if (!$compra) {
            return redirect()->back();
        }

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'ID_Usuario' => 'required|integer',
                'Total' => 'required|numeric',
                'Fecha_Compra' => 'required|valid_date',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'ID_Usuario' => $this->request->getPost('ID_Usuario'),
                    'Total' => $this->request->getPost('Total'),
                    'Fecha_Compra' => $this->request->getPost('Fecha_Compra'),
                    'Estado' => $this->request->getPost('Estado'),
                ];

                $model->update($id, $data);
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        }

        $data['compra'] = $compra;
        return view('dashboard/administrador/admin_editar_compra', $data);
    }

    public function admin_eliminar_compra($id)
    {
        $model = new CompraModel();
        if ($model->find($id)) {
            $model->delete($id);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
    //tiene_productos
    public function admin_tproductos()
    {
        $model = new TieneProductoModel();
        $usuarioModel = new UsuarioModel();  // Modelo de artesanos
        $productoModel = new ProductoModel();

        $data['productos'] = $model->findAll();
        $data['artesanos'] = $usuarioModel->findAll();
        $data['productos_list'] = $productoModel->findAll();

        return view('dashboard/administrador/admin_productos', $data);
    }

    public function admin_editar_tproducto($idArtesano, $idProducto)
    {
        $model = new TieneProductoModel();
        helper(['form']);
        $producto = $model->where('ID_Artesano', $idArtesano)->where('ID_Producto', $idProducto)->first();

        if (!$producto) {
            return redirect()->back()->with('message', 'Producto no encontrado.');
        }

        $rules = [
            'Precio' => 'required|decimal',
            'Stock' => 'required|integer',
            'Disponibilidad' => 'required|integer',
        ];

        $imagen = $this->request->getFile('Imagen_URL');

        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(FCPATH . 'images/productos/', $nombreImagen);
            $imagenURL = base_url('images/productos/' . $nombreImagen);
        }

        $data = [
            'Precio' => $this->request->getPost('Precio'),
            'Stock' => $this->request->getPost('Stock'),
            'Disponibilidad' => $this->request->getPost('Disponibilidad'),
        ];

        if (isset($imagenURL)) {
            $data['Imagen_URL'] = $imagenURL;
        }

        $model->where('ID_Artesano', $idArtesano)->where('ID_Producto', $idProducto)->update(null, $data);

        return redirect()->to(base_url('dashboard/administrador/admin_productos'))->with('message', 'Producto actualizado correctamente.');
    }

    public function admin_agregar_tproducto()
    {
        helper(['form']);
        $model = new TieneProductoModel();

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'ID_Artesano' => 'required|integer',
                'ID_Producto' => 'required|integer',
                'Precio' => 'required|decimal',
                'Stock' => 'required|integer',
                'Disponibilidad' => 'required|integer',
            ];

            if ($this->validate($rules)) {
                $imagen = $this->request->getFile('imagen');
                if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
                    $nombreImagen = $imagen->getRandomName();
                    $imagen->move(FCPATH . 'images/productos/', $nombreImagen);
                    $imagenURL = base_url('images/productos/' . $nombreImagen);
                } else {
                    $imagenURL = base_url('images/productos/default.png');
                }

                $data = [
                    'ID_Artesano' => $this->request->getPost('ID_Artesano'),
                    'ID_Producto' => $this->request->getPost('ID_Producto'),
                    'Precio' => $this->request->getPost('Precio'),
                    'Stock' => $this->request->getPost('Stock'),
                    'Disponibilidad' => $this->request->getPost('Disponibilidad'),
                    'Imagen_URL' => $imagenURL,
                ];

                if ($model->insert($data)) {
                    return redirect()->to(base_url('dashboard/administrador/admin_productos'))->with('success', 'Producto agregado exitosamente');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Ocurrió un error al agregar el producto');
                }
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }
    }
    public function admin_eliminar_tproducto($idArtesano, $idProducto)
    {
        $model = new TieneProductoModel();

        if ($model->where('ID_Artesano', $idArtesano)->where('ID_Producto', $idProducto)->first()) {
            $model->where('ID_Artesano', $idArtesano)->where('ID_Producto', $idProducto)->delete();
            return redirect()->back()->with('message', 'Producto eliminado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }
    }

    public function pago_completado($id)
    {
        $model = new PagoModel();

        if ($model->update($id, ['Estado' => 'COMPLETADO'])) {
            return redirect()->back()->with('message', 'Pago completado.');
        } else {
            return redirect()->back()->with('message', 'Error al completar el pago.');
        }
    }

    public function pago_fallido($id)
    {
        $model = new PagoModel();

        if ($model->update($id, ['Estado' => 'FALLIDO'])) {
            return redirect()->back()->with('message', 'Pago fallido.');
        } else {
            return redirect()->back()->with('message', 'Error al registrar el pago fallido.');
        }
    }
    //TRANSPORTE
    public function transporte()
    {
        $transporteModel = new TransporteModel();
        $data['transportes'] = $transporteModel->findAll();
        return view('dashboard/administrador/admin_transporte', $data);
    }

    public function agregar_transporte()
    {
        if ($this->request->getMethod() === 'post') {
            $transporteModel = new TransporteModel();
            $data = [
                'Tipo' => $this->request->getPost('Tipo'),
                'Descripcion' => $this->request->getPost('Descripcion'),
                'Costo_por_km' => $this->request->getPost('Costo_por_km'),
                'Capacidad' => $this->request->getPost('Capacidad'),
                'Estado' => $this->request->getPost('Estado'),
            ];
            $transporteModel->insert($data);
            return redirect()->to(base_url('administrador/transporte'))->with('success', 'Transporte agregado exitosamente.');
        }
        return view('dashboard/administrador/admin_transporte');
    }

    public function editar_transporte($id)
    {
        $transporteModel = new TransporteModel();
        $transporte = $transporteModel->find($id);
        if (!$transporte) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Transporte no encontrado.');
        }
        if ($this->request->getMethod() === 'POST') { 
            $data = [
                'Tipo' => $this->request->getPost('Tipo'),
                'Descripcion' => $this->request->getPost('Descripcion'),
                'Costo_por_km' => $this->request->getPost('Costo_por_km'),
                // 'Capacidad' => $this->request->getPost('Capacidad'),
                // 'Estado' => $this->request->getPost('Estado'),
            ];
            $transporteModel->update($id, $data);
            return redirect()->to(base_url('dashboard/administrador/admin_transporte'))->with('success', 'Transporte actualizado exitosamente.');
        }
        return view('dashboard/administrador/admin_transporte', ['transporte' => $transporte]);
    }

    public function eliminar_transporte($id)
    {
        // Load the TransporteModel
        $transporteModel = new TransporteModel();

        // Check if the `transporte` exists
        $transporte = $transporteModel->find($id);

        if (!$transporte) {
            // If `transporte` not found, show 404 error
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Transporte no encontrado.');
        }

        // Delete the `transporte` record
        $transporteModel->delete($id);

        // Redirect back to the transport list with success message
        return redirect()->to(base_url('dashboard/administrador/admin_transporte'))->with('success', 'Transporte eliminado exitosamente.');
    }


}