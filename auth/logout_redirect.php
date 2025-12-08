<?php
/**
 * ARCHIVO NUEVO: logout_redirect.php
 *  Se usa para cerrar la sesion del usuario y redirigirlo al login
 */

// Iniciamos la sesión para poder destruirla
session_start();

// Destruimos toda la sesión
session_destroy();

// Redirigimos al login
header("Location: /Proyecto_final/auth/login.php");
exit;
?>