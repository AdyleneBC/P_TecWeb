<?php
require __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/myapi/DataBase.php';
require_once __DIR__ . '/myapi/Create/Create.php';
require_once __DIR__ . '/myapi/Read/Read.php';
require_once __DIR__ . '/myapi/Update/Update.php';
require_once __DIR__ . '/myapi/Delete/Delete.php';

use MYAPI\Read\Read;
use MYAPI\Create\Create;
use MYAPI\Update\Update;
use MYAPI\Delete\Delete;

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

// AJUSTA ESTA RUTA A TU PROYECTO FINAL
$app->setBasePath('/proyectos/tecweb/proyecto/backend');

$app->addRoutingMiddleware();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// GET /products -> lista recursos
$app->get('/products', function (Request $request, Response $response) {
    $read = new Read("dashboard_recursos"); // <-- tu BD
    $read->list();
    $response->getBody()->write(json_encode($read->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});

// GET /product/{id} -> recurso individual
$app->get('/product/{id}', function (Request $request, Response $response, array $args) {
    $read = new Read("dashboard_recursos");
    $read->single($args['id']);
    $response->getBody()->write(json_encode($read->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});

// GET /products/{search} -> buscar recurso
$app->get('/products/{search}', function (Request $request, Response $response, array $args) {
    $read = new Read("dashboard_recursos");
    $read->search($args['search']);
    $response->getBody()->write(json_encode($read->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});

// POST /product -> crear recurso
$app->post('/product', function (Request $request, Response $response) {
    $params = (array)$request->getParsedBody();

    $create = new Create("dashboard_recursos");
    $create->add($params);

    $resp = $create->getData();
    $response->getBody()->write($resp);
    return $response->withHeader('Content-Type', 'application/json');
});

// PUT /product -> modificar recurso
$app->put('/product', function (Request $request, Response $response) {
    $params = (array)$request->getParsedBody();

    $update = new Update("dashboard_recursos");
    $update->edit($params);

    $resp = $update->getData();
    $response->getBody()->write($resp);
    return $response->withHeader('Content-Type', 'application/json');
});

// DELETE /product -> eliminar lógico
$app->delete('/product', function (Request $request, Response $response) {
    $params = (array)$request->getParsedBody();
    $id = $params['id'] ?? 0;

    $delete = new Delete("dashboard_recursos");
    $delete->delete($id);

    $resp = $delete->getData();
    $response->getBody()->write($resp);
    return $response->withHeader('Content-Type', 'application/json');
});

/**/
// GET /download/{id}  -> descarga + bitácora
$app->get('/download/{id}', function (Request $request, Response $response, array $args) {

    $id = intval($args['id']);

    $cn = new mysqli("localhost", "root", "adylene", "dashboard_recursos");

    // 1) buscar el recurso
    $q = $cn->query("SELECT archivo FROM recursos WHERE id_recurso=$id AND eliminado=0");
    if ($q->num_rows == 0) {
        $response->getBody()->write("No existe el recurso");
        return $response;
    }

    $row = $q->fetch_assoc();
    $archivo = $row['archivo'];

    // 2) guardar bitacora (si ya la estás usando)
    $ip = $_SERVER['REMOTE_ADDR'];
    $cn->query("INSERT INTO bitacora_descargas(id_recurso_fk, ip) VALUES($id,'$ip')");

    $cn->close();

    // 3) forzar descarga
    $ruta = __DIR__ . "/../assets/uploads/" . $archivo;
    if (!file_exists($ruta)) {
        $response->getBody()->write("Archivo no encontrado");
        return $response;
    }

    $stream = new \Slim\Psr7\Stream(fopen($ruta, "rb"));

    return $response
        ->withHeader("Content-Type", "application/octet-stream")
        ->withHeader("Content-Disposition", "attachment; filename=" . basename($ruta))
        ->withBody($stream);
});

/* */

$app->run();
