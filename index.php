<?php
// Headers 
/*header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json; charset=utf-8');*/

header("Access-Control-Allow-Origin: http://localhost/ultraWEB/usuario");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

//env 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//* crear app y activar reescritura

$app = AppFactory::create();

if (PHP_SAPI == 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}
// cargar todos los elementos de la app
require __DIR__ . '/src/loadApp.php';

$app->get('/', function (Request $request, Response $response) {
    $dbHost = $_ENV['DB_HOST'];
    $response->withHeader('Content-type','application/json')
             ->getBody()->write("Pagina principal");
    return $response;
});


$app->run();