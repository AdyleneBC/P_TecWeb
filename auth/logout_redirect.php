<?php
/**
 * ARCHIVO NUEVO: logout_redirect.php
 * 
 * PROPÓSITO: Cerrar la sesión del usuario y redirigirlo al login.
 * Este archivo se llamará desde el botón de "Cerrar sesión" en el frontend.
 * 
 * UBICACIÓN: Colocar en la raíz del proyecto junto a logout.php
 * Ruta: C:\xampp\htdocs\Proyecto_Final\logout_redirect.php
 */

// Iniciamos la sesión para poder destruirla
session_start();

// Destruimos toda la sesión
session_destroy();

// Redirigimos al login
header("Location: /Proyecto_final/auth/login.php");
exit;
?>