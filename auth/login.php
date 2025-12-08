<?php
// Usamos un 'modo' debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // IMPORTANTE: Iniciar sesión ANTES de todo

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    echo "<!-- DEBUG: Formulario enviado -->\n";
    
    try {
        $mysqli = require __DIR__ . "/../database.php";
        echo "<!-- DEBUG: Conexión exitosa -->\n";
    } catch (Exception $e) {
        die("ERROR AL CONECTAR: " . $e->getMessage());
    }

    $sql = "SELECT id, email, password_hash, role FROM user WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    
    if (!$stmt) {
        die("ERROR EN PREPARE: " . $mysqli->error);
    }
    
    $stmt->bind_param("s", $_POST["email"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    echo "<!-- DEBUG: Usuario encontrado: " . ($user ? "SÍ" : "NO") . " -->\n";

    if ($user) {
        echo "<!-- DEBUG: Hash en BD: " . substr($user["password_hash"], 0, 20) . "... -->\n";
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            echo "<!-- DEBUG: Contraseña correcta -->\n";
            
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
            
            echo "<!-- DEBUG: Sesión iniciada con user_id: " . $user["id"] . " -->\n";
            
            // Verificamos si hay descarga pendiente
            if (isset($_SESSION['intended_download'])) {
                $download_id = $_SESSION['intended_download'];
                echo "<!-- DEBUG: Hay descarga pendiente ID: " . $download_id . " -->\n";
                
                // Limpiar la descarga pendiente de la sesión
                unset($_SESSION['intended_download']);
                
                // Redirigir a la API de descarga (OJO: no a download_public.php)
                echo "<!-- DEBUG: Redirigiendo a descarga: /Proyecto_final/api/download/" . $download_id . " -->\n";
                header("Location: /Proyecto_final/api/download/" . $download_id);
                exit;
            }
            
            // Si no hay descarga pendiente, ir al panel normal
            echo "<!-- DEBUG: Sin descarga pendiente, redirigiendo a /Proyecto_final/app/index.html -->\n";
            header("Location: /Proyecto_final/app/index.html");
            exit;
        } else {
            echo "<!-- DEBUG: Contraseña incorrecta -->\n";
        }
    }
    
    $is_invalid = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - ResourceApp</title>
    
    <!-- BOOTSTRAP 4 (Bootswatch Slate) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/slate/bootstrap.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            max-width: 450px;
            width: 100%;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-header h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .brand-header p {
            color: rgba(255,255,255,0.9);
            font-size: 1.1rem;
        }

        .login-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }

        .card-header {
            background: #222;
            color: white;
            border-radius: 8px 8px 0 0;
            padding: 20px;
        }

        .card-header h5 {
            margin: 0;
            font-size: 1.3rem;
        }

        .card-body {
            padding: 30px;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .footer-links {
            text-align: center;
            margin-top: 20px;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 500;
            transition: opacity 0.3s ease;
        }

        .footer-links a:hover {
            opacity: 0.8;
        }

        .alert {
            border-radius: 5px;
            border: none;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        
        <div class="brand-header">
            <h1>ResourceApp</h1>
            <p>Inicia sesión para continuar</p>
        </div>

        <div class="card login-card">
            <div class="card-header">
                <h5>Iniciar Sesión</h5>
            </div>
            
            <div class="card-body">
                
                <?php if ($is_invalid): ?>
                    <div class="alert alert-danger mb-3">
                        <strong>Error:</strong> Correo o contraseña incorrectos.
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['intended_download'])): ?>
                    <div class="alert alert-info mb-3">
                        <strong>Casi listo:</strong> Inicia sesión para descargar tu recurso.
                    </div>
                <?php endif; ?>

                <form method="post" action="/Proyecto_final/auth/login.php">
                    
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="form-control"
                               placeholder="tu@email.com"
                               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" 
                               required
                               autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="form-control"
                               placeholder="Ingresa tu contraseña" 
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login btn-block btn-lg">
                        Iniciar Sesión
                    </button>
                    
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p class="mb-2">
                        ¿No tienes cuenta? 
                        <a href="/Proyecto_final/signup.html" class="text-primary font-weight-bold">Regístrate gratis</a>
                    </p>
                    <a href="/Proyecto_final/catalogo.php" class="text-muted">Volver al Catálogo</a>
                </div>

            </div>
        </div>

        <div class="footer-links">
            <a href="/Proyecto_final/">Inicio</a>
            <span style="color: rgba(255,255,255,0.5);">|</span>
            <a href="/Proyecto_final/catalogo.php">Catálogo</a>
        </div>

    </div>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

</body>
</html>