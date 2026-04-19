<?php
namespace App\Router;
require_once __DIR__ . '/../../vendor/autoload.php';

use Bramus\Router\Router;

$router = new Router();

require __DIR__ . '/Usuarios.php';
require __DIR__ . '/Reservas.php';
require __DIR__ . '/Software.php';
require __DIR__ . '/Salas.php';
require __DIR__ . '/Equipamentos.php';

header('Content-Type: application/json');


$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo '404, route not found!';
});


$router->set404('/test(/.*)?', function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo '<h1><mark>404, route not found!</mark></h1>';
});

$router->set404('/api(/.*)?', function() {
    header('HTTP/1.1 404 Not Found');
    header('Content-Type: application/json');
    $jsonArray = array();
    $jsonArray['status'] = "404";
    $jsonArray['status_text'] = "route not defined";
    echo json_encode($jsonArray);
});

$router->before('GET', '/.*', function () {
    header('X-Powered-By: bramus/router');
});
   
addUsuarioRoutes($router);
addReservaRoutes($router);
addSoftwareRoutes($router);
addSalaRoutes($router);
addEquipamentoRoutes($router);

$router->run();

// EOF
