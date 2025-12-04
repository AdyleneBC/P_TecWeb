<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT id, email, password_hash, role FROM user WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $_POST["email"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($_POST["password"], $user["password_hash"])) {
        session_start();
        session_regenerate_id();
        $_SESSION["user_id"] = $user["id"];
        header("Location: index.php");
        exit;
    }
    $is_invalid = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/4/pulse/bootstrap.min.css">
    <title>Iniciar sesión</title>
</head>
<body class="container mt-4">
    <h1>Iniciar sesión</h1>

    <?php if ($is_invalid): ?>
        <div class="alert alert-danger">Correo o contraseña incorrectos.</div>
    <?php endif; ?>

    <form method="post" action="login.php">
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary btn-lg">Iniciar sesión</button>
    </form>

    <p class="mt-3">
        ¿No tienes cuenta? <a href="signup.html">Regístrate</a>
    </p>
</body>
</html>