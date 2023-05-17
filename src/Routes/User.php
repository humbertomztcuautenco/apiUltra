<?php
use App\Controllers\UserController;
use App\Lib\Auth;
use App\Middleware\AuthMiddleware;
use Slim\Routing\RouteCollectorProxy;

$authMiddleware = new AuthMiddleware();

$app->group('/api/user/', function (RouteCollectorProxy $group) use ($authMiddleware) {
    $group->get('getInfo/{token}', UserController::class.':getInfo');//listo
});