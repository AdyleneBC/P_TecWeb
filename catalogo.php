<?php
/**
 * Vista de la ventana de Catalogo
 */

session_start();

$is_logged_in = isset($_SESSION["user_id"]);
$user = null;

if ($is_logged_in) {
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT id, name, email, role FROM user WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo Público - ResourceApp</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/slate/bootstrap.min.css">
    
    <style>
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .resource-card {
            transition: transform 0.2s;
            cursor: pointer;
        }
        
        .resource-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .download-btn {
            width: 100%;
        }
        
        .resource-icon {
            font-size: 3rem;
            margin-bottom: 10px;
            font-weight: bold;
            color: #667eea;
        }
        
        .login-prompt {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/Proyecto_final/">ResourceApp</a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <?php if ($is_logged_in): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/Proyecto_final/app/index.html">
                                Mi Cuenta (<?= htmlspecialchars($user['name']) ?>)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/Proyecto_final/auth/logout_redirect.php">
                                Cerrar Sesión
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-success text-white" href="/Proyecto_final/auth/login.php">
                                Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item ml-2">
                            <a class="nav-link btn btn-outline-light" href="/Proyecto_final/signup.html">
                                Registrarse
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        
        <?php if (!$is_logged_in): ?>
        <div class="login-prompt">
            <h2>Accede a Recursos Digitales Gratuitos</h2>
            <p class="lead">
                Explora nuestra colección de recursos educativos, herramientas y documentos.
                <strong>Regístrate gratis</strong> para descargar cualquier archivo.
            </p>
            <a href="/Proyecto_final/signup.html" class="btn btn-light btn-lg mr-2">
                Crear Cuenta Gratis
            </a>
            <a href="/Proyecto_final/auth/login.php" class="btn btn-outline-light btn-lg">
                Ya tengo cuenta
            </a>
        </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-md-12">
                <h1>Catálogo de Recursos Digitales</h1>
                <p class="text-muted">Explora nuestra colección de archivos disponibles</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <div class="input-group">
                    <input type="text" class="form-control" id="search" 
                           placeholder="Buscar por nombre, tipo, lenguaje...">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="button" id="searchBtn">
                            Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="recursos-container">
            <div class="col-12 text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Cargando...</span>
                </div>
                <p>Cargando recursos...</p>
            </div>
        </div>

    </div>

    <footer class="mt-5 py-4 bg-dark text-white text-center">
        <div class="container">
            <p class="mb-0">&copy; 2024 ResourceApp - Sistema de Gestión de Recursos Digitales</p>
            <?php if (!$is_logged_in): ?>
            <p class="text-muted mb-0">
                <a href="/Proyecto_final/signup.html" class="text-light">Regístrate</a> para descargar recursos
            </p>
            <?php endif; ?>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

    <script>
        const API = "/Proyecto_final/api";
        const isLoggedIn = <?= $is_logged_in ? 'true' : 'false' ?>;

        function getIcon(tipo) {
            tipo = (tipo || '').toLowerCase();
            const icons = {
                'pdf': '[PDF]',
                'zip': '[ZIP]',
                'jar': '[JAR]',
                'exe': '[EXE]',
                'json': '[JSON]',
                'xml': '[XML]',
                'otro': '[FILE]'
            };
            return icons[tipo] || '[DOC]';
        }

        function cargarRecursos(searchTerm = '') {
            const url = searchTerm 
                ? `${API}/products/${encodeURIComponent(searchTerm)}`
                : `${API}/products`;

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    const recursos = Array.isArray(response) ? response : JSON.parse(response);
                    mostrarRecursos(recursos);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#recursos-container').html(`
                        <div class="col-12">
                            <div class="alert alert-danger">
                                Error al cargar los recursos. Intenta nuevamente.
                            </div>
                        </div>
                    `);
                }
            });
        }

        function mostrarRecursos(recursos) {
            if (recursos.length === 0) {
                $('#recursos-container').html(`
                    <div class="col-12">
                        <div class="alert alert-info">
                            No se encontraron recursos.
                        </div>
                    </div>
                `);
                return;
            }

            let html = '';
            recursos.forEach(r => {
                const icon = getIcon(r.tipo);
                const recursoId = r.id_recurso || r.id;
                
                const downloadUrl = isLoggedIn 
                    ? `/Proyecto_final/api/download/${recursoId}`
                    : `/Proyecto_final/download_public.php?id=${recursoId}`;

                html += `
                    <div class="col-md-4 mb-4">
                        <div class="card resource-card h-100">
                            <div class="card-body text-center">
                                <div class="resource-icon">${icon}</div>
                                <h5 class="card-title">${r.nombre}</h5>
                                <p class="text-muted mb-2">
                                    <small>
                                        <strong>Tipo:</strong> ${r.tipo || 'N/A'} | 
                                        <strong>Lenguaje:</strong> ${r.lenguaje || 'N/A'}
                                    </small>
                                </p>
                                <p class="card-text">${r.descripcion || 'Sin descripción'}</p>
                                <p class="text-muted">
                                    <small><strong>Autor:</strong> ${r.autor || 'N/A'}</small>
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="${downloadUrl}" 
                                   class="btn btn-primary download-btn" 
                                   ${isLoggedIn ? 'target="_blank"' : ''}>
                                    ${isLoggedIn ? 'Descargar' : 'Registrarse para Descargar'}
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#recursos-container').html(html);
        }

        $(document).ready(function() {
            cargarRecursos();

            $('#searchBtn').click(function() {
                const searchTerm = $('#search').val().trim();
                cargarRecursos(searchTerm);
            });

            $('#search').keypress(function(e) {
                if (e.which === 13) {
                    const searchTerm = $(this).val().trim();
                    cargarRecursos(searchTerm);
                }
            });
        });
    </script>
</body>
</html>