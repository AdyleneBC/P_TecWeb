<?php
session_start();

$user = null;
if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT id, name, email, role FROM user WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
        //Es una redireccion para el usuario si esta logueado mandarlo al frontend o la app
if ($user) {
    header("Location: /Proyecto_final/Frontend/index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/4/pulse/bootstrap.min.css">
    <title>Inicio</title>
</head>
<body class="container mt-4">
    <h1>Bienvenido</h1>

    <?php if ($user): ?>
        <p>Hola, <strong><?= htmlspecialchars($user["name"]) ?></strong> 
           (<?= htmlspecialchars($user["role"] === 'admin' ? 'Administrador' : 'Visitante') ?>)</p>

        <?php if ($user["role"] === "admin"): ?>
            <div class="jumbotron">
                <div class="card-header">
                    <h2>Dashboard de Administrador</h2>
                </div>
                <div class="card-body">
                    <p>Aquí podrás <strong>definir y gestionar el catálogo de productos</strong>.</p>
                    <ul class="list-group">
                        <li><a href="Frontend/index.html">Ir a ResourceApp</a></li> 
                    </ul>
                </div>
            </div>
        <?php else: ?>
            <div class="jumbotron">
                <div class="card-header">
                    <h2>Catálogo Público</h2>
                </div>
                <div class="card-body">
                    <p>Explora nuestros productos:</p>
                    <a href="catalog.php" class="btn btn-outline-primary">Ver Catálogo</a>
                </div>
            </div>
        <?php endif; ?>

        <a href="logout.php" class="btn btn-secondary">Cerrar sesión</a>

    <?php else: ?>
        <p>
            <a href="login.php" class="btn btn-primary">Iniciar sesión</a>
            o
            <a href="signup.html" class="btn btn-outline-primary">Registrarse</a>
        </p>
    <?php endif; ?>
</body>
</html>