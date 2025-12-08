<?php
/**
 * ARCHIVO: api/myapi/DataBase.php
 *  Es la clase para todas las operaciones CRUD, partiendfo de la clase Database unificada
 */

namespace MYAPI;

// Se carga la clase Database unificada
require_once __DIR__ . "/../../config/Database.php";

use Config\Database as ConfigDatabase;

abstract class DataBase
{
    // Atributo protegido de conexión
    protected $conexion;

    // Arreglo donde guardaremos los datos que regresan las consultas
    protected $data;

    // Ya no necesita pasarse datos
 
    public function __construct()
    {
        $this->data = array();
        
        // la conectamos a dashboard_recursos
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