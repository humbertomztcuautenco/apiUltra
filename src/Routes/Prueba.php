<?php
use App\Controllers\PruebaController;
use Slim\Routing\RouteCollectorProxy;

$app->group('/apiPrueba/', function(RouteCollectorProxy $group){
    $group->post('usuario', userController::class.':registrarUsuario');
    $group->get('usuario', userController::class.':leerUsuarios');
    $group->put('usuario/{idusers}',userController::class.':actualizarUsuario');
    $group->get('usuario/{idusers}', userController::class.':leerUsuario');
    $group->delete('usuario/{idusers}', userController::class.':eliminarUsuario');
    $group->post('validar', userController::class.':validar');
    $group->post('contrasena', PruebaController::class.':password');


});