<?php
/**
 * Usa la clase Database unificada
 * Este archivo ahora usa la clase Database unificada.
 */

// Se carga la clase Database unificada
require_once __DIR__ . "/config/Database.php";

use Config\Database;

// Se retorna la conexion a login_db
return Database::getLoginConnection();
?>