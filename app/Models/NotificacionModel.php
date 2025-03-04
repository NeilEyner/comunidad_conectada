<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificacionModel extends Model
{
    protected $table      = 'notificacion';
    protected $primaryKey = 'ID';

    // Las columnas que puedes insertar
    protected $allowedFields = [
        'ID_Usuario', 
        'Tipo', 
        'Mensaje', 
        'Fecha', 
        'Leido', 
        'Canal', 
        'Prioridad'
    ];

    // Las columnas que no se deben modificar
    protected $useTimestamps = false;  // La columna Fecha no es manejada por el framework
    protected $createdField  = 'Fecha'; // Si se requiere auto-generar el campo `Fecha`
    
    // Regla de validación
    protected $validationRules = [
        'ID_Usuario' => 'required|integer',
        'Tipo'       => 'required|in_list[COMPRA,ENVIO,PRODUCTO,SISTEMA,PROMOCION,SEGURIDAD]',
        'Mensaje'    => 'required|string',
        'Leido'      => 'permit_empty|in_list[0,1]',
        'Canal'      => 'permit_empty|in_list[APP,EMAIL,SMS,PUSH]',
        'Prioridad'  => 'permit_empty|in_list[BAJA,MEDIA,ALTA,CRITICA]'
    ];

    // Configuración de las relaciones de claves foráneas
    public function getUsuario()
    {
        return $this->join('usuario', 'usuario.ID = notificacion.ID_Usuario');
    }
    public function registrarNotificacion($usuarioID, $tipo, $mensaje, $canal = 'PUSH', $prioridad = 'BAJA')
    {
        $data = [
            'ID_Usuario' => $usuarioID,
            'Tipo' => $tipo,
            'Mensaje' => $mensaje,
            'Fecha' => date('Y-m-d H:i:s'), // Usamos la fecha actual
            'Leido' => 0, // Inicialmente no leída
            'Canal' => $canal,
            'Prioridad' => $prioridad
        ];

        return $this->insert($data); // Insertar en la base de datos
    }

    // Obtener notificaciones no leídas de un usuario
    public function obtenerNotificacionesNoLeidas($usuarioID)
    {
        return $this->where('ID_Usuario', $usuarioID)
                    ->where('Leido', 0)
                    ->orderBy('fecha', 'DESC')
                    ->limit(4)
                    ->findAll();
    }

    // Marcar una notificación como leída
    public function marcarComoLeida($notificacionID)
    {
        return $this->update($notificacionID, ['Leido' => 1]);
    }
}
