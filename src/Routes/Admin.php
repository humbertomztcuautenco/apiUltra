<?php
use App\Controllers\AdminController;
use App\Lib\Auth;
use App\Middleware\AuthMiddleware;
use Slim\Routing\RouteCollectorProxy;

$authMiddleware = new AuthMiddleware();

$app->group('/api/admin/', function (RouteCollectorProxy $group) use ($authMiddleware) {
    //carreras
    $group->post('crearCarrera/{token}', AdminController::class.':crearCarrera');//listo
    $group->get('misCarreras/{token}', AdminController::class.':misCarreras');//listo
    $group->put('datosCarrera/{token}', AdminController::class.':datosCarrera');//listo
    $group->delete('eliminarCarrera/{token}', AdminController::class.':delCarrera');//listo
    //distancias
    $group->post('distancia/{token}', AdminController::class.':distance');//listo
    $group->get('verDistancias/{token}', AdminController::class.':verDistance');//listo
    $group->put('actDistancia/{token}', AdminController::class.':actDistancia');//listo
    $group->delete('eliminarDistancia/{token}', AdminController::class.':delDistance');//listo
    //avisos
    $group->post('crearAviso/{token}', AdminController::class.':crearAviso');//listo
    $group->put('actualizarAviso/{token}', AdminController::class.':actAviso');//listo
    $group->get('verAvisos/{token}', AdminController::class.':verAviso');//listo
    $group->delete('eliminarAviso/{token}', AdminController::class.':delAviso');//listo
    //acerca de
    $group->post('crearAcercaDe/{token}', AdminController::class.':addAcerca');//listo
    $group->put('actualizarAcercaDe/{token}', AdminController::class.':actAcerca');//listo
    $group->get('verAcercaDe/{token}', AdminController::class.':verAcerca');//listo
    $group->delete('eliminarAcercaDe/{token}', AdminController::class.':delAcerca');//listo
    //contacto
    $group->post('agregarContacto/{token}', AdminController::class.':addContact');//listo
    $group->put('actualizarContacto/{token}', AdminController::class.':actContact');//listo
    $group->get('verContactos/{token}', AdminController::class.':verContacts');//listo
    $group->delete('eliminarContacto/{token}', AdminController::class.':delContact');//listo
});