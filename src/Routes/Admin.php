<?php
use App\Controllers\AdminController;
use App\Lib\Auth;
use App\Middleware\AuthMiddleware;
use Slim\Routing\RouteCollectorProxy;

$authMiddleware = new AuthMiddleware();

$app->group('/api/admin/', function (RouteCollectorProxy $group) use ($authMiddleware) {
    //carreras
    $group->post('crearCarrera/{token}', AdminController::class.':crearCarrera');//listo
    $group->get('verCarreras/{token}', AdminController::class.':verCarreras');//listo
    $group->put('actualizarCarrera/{token}', AdminController::class.':actCarrera');//listo
    $group->delete('eliminarCarrera/{token}', AdminController::class.':delCarrera');//listo
    //distancias
    $group->post('distancia/{token}', AdminController::class.':distance');//listo
    $group->get('verDistancias/{token}', AdminController::class.':verDistance');//listo
    $group->put('actDistancia/{token}', AdminController::class.':actDistancia');//listo
    $group->delete('eliminarDistancia/{token}', AdminController::class.':delDistance');//listo
    $group->get('nombreDistancias/{token}', AdminController::class.':nombreDistancia');//listo
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
    //turismo
    $group->post('agregarTurismo/{token}', AdminController::class.':addTurismo');//listo
    $group->put('actualizarTurismo/{token}', AdminController::class.':actTurismo');
    $group->get('verTurismo/{token}', AdminController::class.':verTurismo');//listo
    $group->delete('eliminarTurismo/{token}', AdminController::class.':delTurismo');//listo

    $group->get('carreras', AdminController::class.':todasCarreras');//listo
    //boletos
    $group->post('agregarBoleto/{token}', AdminController::class.':addBoleto');//listo
    $group->get('verBoleto/{token}', AdminController::class.':verBoleto');//listo
    $group->get('verBoleto2/{token}', AdminController::class.':verBoleto2');//listo
<<<<<<< HEAD
    $group->put('actualizarBoleto/{token}', AdminController::class.':actBoleto');//listo
    $group->delete('eliminarBoleto/{token}', AdminController::class.':delBoleto');//listo
    //imagenes
    $group->post('agregarImagen/{token}', AdminController::class.':addImagen');//listo
    $group->get('verImagen/{token}', AdminController::class.':verImagen');//listo
=======
>>>>>>> main
});