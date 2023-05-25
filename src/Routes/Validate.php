<?php
use App\Controllers\ValidateController;
use App\Lib\Auth;
use App\Middleware\AuthMiddleware;
use Slim\Routing\RouteCollectorProxy;

$authMiddleware = new AuthMiddleware();

$app->group('/api/', function (RouteCollectorProxy $group) use ($authMiddleware) {
    // validar email
    $group->post('validarEmail', ValidateController::class.':validarEmail');//listo
    $group->post('validarCodigo', ValidateController::class.':validarCodigo');//listo
    // registrar cliente
    $group->post('registrarCliente', ValidateController::class.':registrarCliente')->add($authMiddleware);//listo
    $group->post('registrarAdmin', ValidateController::class.':registrarAdmin')->add($authMiddleware);
    $group->post('registrarStaff', ValidateController::class.':registrarStaff')->add($authMiddleware);
    // auth 
    $group->post('auth', ValidateController::class.':auth');//listo
    // recuperar password
    $group->post('enCodigoPassword',ValidateController::class.':enCodigoPassword');//listo
    $group->post('vaCodigoPassword',ValidateController::class.':vaCodigoPassword');//listo
    $group->post('recuperarPassword',ValidateController::class.':recuperarPassword')->add($authMiddleware);//listo

    $group->get('getUser/{token}', ValidateController::class.':getUser');//listo
    $group->get('getCodePais', ValidateController::class.':getCodePais');
    
    $group->post('validarToken/{token}', ValidateController::class.':validateToken');
   
});