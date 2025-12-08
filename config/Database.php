<?php
/**
 * Aqui se centraliza todas las conexiones a las bases de datos (la clase database unificada)
 */

namespace Config;

class Database 
{
    private static $host = "localhost";
    private static $username = "root";
    private static $password = "celo218crlo218.";
    
    // Conexión para SISTEMA DE LOGIN (login_db)
    public static function getLoginConnection() 
    {
        $dbname = "login_db";
        
        $mysqli = new \mysqli(
            self::$host, 
            self::$username, 
            self::$password, 
            $dbname
        );
        
        if ($mysqli->connect_errno) {
            die("Error de conexión (login_db): " . $mysqli->connect_error);
        }
        
        return $mysqli;
    }
    
    // Conexión para SISTEMA DE RECURSOS (dashboard_recursos)
    public static function getResourcesConnection() 
    {
        $dbname = "dashboard_recursos";
        
        $mysqli = new \mysqli(
            self::$host, 
            self::$username, 
            self::$password, 
            $dbname
        );
        
        if ($mysqli->connect_errno) {
            die("Error de conexión (dashboard_recursos): " . $mysqli->connect_error);
        }
        
        return $mysqli;
    }
    
    // Conexión genérica
    public static function getConnection($dbname) 
    {
        $mysqli = new \mysqli(
            self::$host, 
            self::$username, 
            self::$password, 
            $dbname
        );
        
        if ($mysqli->connect_errno) {
            die("Error de conexión ($dbname): " . $mysqli->connect_error);
        }
        
        return $mysqli;
    }
}
?>