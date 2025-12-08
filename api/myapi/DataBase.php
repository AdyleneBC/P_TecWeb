<?php
/**
 * ARCHIVO: api/myapi/DataBase.php
 * 
 * UBICACIÓN: C:\xampp\htdocs\Proyecto_Final\api\myapi\DataBase.php
 * 
 * PROPÓSITO: Clase base para operaciones CRUD
 * MODIFICACIÓN: Ahora usa la clase Database unificada
 */

namespace MYAPI;

// ============================================
// CARGAMOS LA CLASE DATABASE UNIFICADA
// ============================================
require_once __DIR__ . "/../../config/Database.php";

use Config\Database as ConfigDatabase;

abstract class DataBase
{
    // Atributo protegido de conexión
    protected $conexion;

    // Arreglo donde guardaremos los datos que regresan las consultas
    protected $data;

    // ============================================
    // CONSTRUCTOR MODIFICADO
    // Ya no necesita user, pass, db como parámetros
    // ============================================
    public function __construct()
    {
        $this->data = array();
        
        // ============================================
        // USAR LA CLASE DATABASE UNIFICADA
        // Conectamos a dashboard_recursos
        // ============================================
        $this->conexion = ConfigDatabase::getResourcesConnection();
        
        if (!$this->conexion) {
            die('¡Base de datos NO conectada!');
        }
    }

    // getData(): string
    public function getData()
    {
        // Regresa los datos como JSON
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}