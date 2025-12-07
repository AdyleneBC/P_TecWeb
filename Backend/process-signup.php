<?php
ob_start();

// Validaciones
if (empty($_POST["name"])) {
    die("El nombre es requerido");
}
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Se requiere un correo electrónico válido");
}
if (strlen($_POST["password"]) < 8) {
    die("La contraseña debe tener al menos 8 caracteres");
}
if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("La contraseña debe contener al menos una letra");
}
if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("La contraseña debe contener al menos un número");
}
if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Las contraseñas deben coincidir");
}

// Determinar rol dependiendo del dominio del correo
$email = $_POST["email"];
$role = preg_match('/@productapp\.com$/i', $email) ? 'admin' : 'visitor';

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";


$sql = "INSERT INTO user (name, email, password_hash, role) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Error SQL: " . $mysqli->error);
}


$stmt->bind_param("ssss", $_POST["name"], $email, $password_hash, $role);

try {
    $stmt->execute();
    header("Location: signup-success.html");
    exit;
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() === 1062) {
        die("Ya existe una cuenta con ese correo electrónico.");
    } else {
        die("Error: " . $e->getMessage());
    }
}