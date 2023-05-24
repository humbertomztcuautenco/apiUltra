<?php
use App\Controllers\CorredorController;
use App\Lib\Auth;
use App\Middleware\AuthMiddleware;
use Slim\Routing\RouteCollectorProxy;

$authMiddleware = new AuthMiddleware();

$app->group('/api/corredor/', function (RouteCollectorProxy $group) use ($authMiddleware) {
    $group->get('getInfo/{token}', CorredorController::class.':getInfo');//listo
    //corredor
    $group->post('agregarCorredor/{token}', CorredorController::class.':addCorredor');//listo
    $group->get('Favoritos/{token}', CorredorController::class.':verFavorito');//listo
    $group->delete('eliminarFavorito/{token}', CorredorController::class.':delFavorito');//listo
});