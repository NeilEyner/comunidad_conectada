<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaModel extends Model
{
    protected $table      = 'auditoria_evento';
    protected $primaryKey = 'ID';

    // Las columnas que puedes insertar
    protected $allowedFields = [
        'ID_Usuario', 
        'Tipo_Evento', 
        'Descripcion', 
        'Fecha', 
        'Direccion_IP', 
        'Dispositivo', 
        'Ubicacion'
    ];

    // Las columnas que no se deben modificar
    protected $useTimestamps = false; // Similar a la tabla notificacion
    protected $createdField  = 'Fecha'; // Si se requiere auto-generar el campo `Fecha`
    
    // Regla de validación
    protected $validationRules = [
        'ID_Usuario'  => 'permit_empty|integer',
        'Tipo_Evento' => 'required|in_list[LOGIN,LOGOUT,COMPRA,CAMBIO_PERFIL,SEGURIDAD,SISTEMA]',
        'Descripcion' => 'required|string',
        'Direccion_IP'=> 'permit_empty|valid_ip',
        'Dispositivo' => 'permit_empty|string',
        'Ubicacion'   => 'permit_empty|string'
    ];

    // Configuración de las relaciones de claves foráneas
    public function getUsuario()
    {
        return $this->join('usuario', 'usuario.ID = auditoria_evento.ID_Usuario', 'left');
    }
    public function registrarEvento($tipoEvento, $usuarioID, $usuarioNombre, $ipAddress, $userAgent, $location = 'LA PAZ', $descripcion = null)
    {
        // Determinar el dispositivo
        $device = $userAgent->isMobile() ? 'Móvil' : ($userAgent->isBrowser() ? 'PC' : 'Desconocido');
        
        // Si no se pasa una descripción, generarla automáticamente según el tipo de evento
        if (!$descripcion) {
            $descripcion = match ($tipoEvento) {
                'LOGIN' => "El {$usuarioNombre} ha iniciado sesión.",
                'LOGOUT' => "El {$usuarioNombre} ha cerrado sesión.",
                'COMPRA' => "El {$usuarioNombre} ha realizado una compra.",
                'CAMBIO_PERFIL' => "El {$usuarioNombre} ha actualizado su perfil.",
                'SEGURIDAD' => "El {$usuarioNombre} ha realizado una acción de seguridad.",
                'SISTEMA' => "El sistema ha registrado un evento.",
                default => "Evento desconocido."
            };
        }

        // Preparar los datos
        $data = [
            'ID_Usuario' => $usuarioID,
            'Tipo_Evento' => $tipoEvento,
            'Descripcion' => $descripcion,
            'Fecha' => date('Y-m-d H:i:s'),
            'Direccion_IP' => $ipAddress,
            'Dispositivo' => $device,
            'Ubicacion' => $location
        ];

        return $this->insert($data);
    }
}
