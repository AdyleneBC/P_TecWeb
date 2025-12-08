<?php
/**
 *      Su proposito es interceptar las descargas y redigirlas a login o signup si no estas autenticado
 *      De lo contrario, te redirige a la API de descarga
 */

session_start();

// Verificar si hay ID de recurso
if (!isset($_GET['id'])) {
    die("ID de recurso no especificado");
}

$id = intval($_GET['id']);

// Verificar si el usuario está logueado
if (!isset($_SESSION["user_id"])) {
    // Usuario NO logueado - guardar el archivo que quería descargar
    $_SESSION['intended_download'] = $id;
    
    echo "<!-- DEBUG: Usuario NO autenticado, guardando descarga pendiente ID: $id -->\n";
    echo "<!-- DEBUG: Redirigiendo a signup.html -->\n";
    
    // Redirigir a la página de registro con mensaje
    header("Location: /Proyecto_final/signup.html?message=register_to_download");
    exit;
}

// Usuario SÍ está logueado - redirigir a la API de descarga
echo "<!-- DEBUG: Usuario autenticado (ID: " . $_SESSION["user_id"] . "), redirigiendo a API -->\n";
echo "<!-- DEBUG: Redirigiendo a /Proyecto_final/api/download/$id -->\n";

header("Location: /Proyecto_final/api/download/$id");
exit;
?>