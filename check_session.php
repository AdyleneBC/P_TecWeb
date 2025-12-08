<?php
/**
 * ARCHIVO NUEVO: check_session.php
 * 
 * PROPÓSITO: Este archivo verifica si hay una sesión activa y devuelve
 * información del usuario en formato JSON para que el frontend pueda
 * decidir qué elementos mostrar según el rol (admin o visitor).
 * 
 * UBICACIÓN: Colocar en la raíz del proyecto junto a login.php
 * Ruta: C:\xampp\htdocs\Proyecto_Final\check_session.php
 */

// Iniciamos la sesión para poder leer datos del usuario logueado
session_start();

// Configuramos el header para que devuelva JSON
header('Content-Type: application/json');

// Verificamos si existe un usuario en sesión
if (isset($_SESSION["user_id"])) {
    
    // Conectamos a la base de datos login_db usando el archivo database.php existente
    $mysqli = require __DIR__ . "/Backend/database.php";
    
    // Consultamos los datos del usuario actual
    $sql = "SELECT id, name, email, role FROM user WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    // Si encontramos el usuario, devolvemos sus datos
    if ($user) {
        echo json_encode([
            'logged_in' => true,
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'] // 'admin' o 'visitor'
            ]
        ]);
    } else {
        // Usuario no encontrado en BD pero existe en sesión (caso extraño)
        echo json_encode(['logged_in' => false]);
    }
    
} else {
    // No hay sesión activa, devolvemos logged_in: false
    echo json_encode(['logged_in' => false]);
}
?>