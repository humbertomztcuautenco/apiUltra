<?php

use App\Controllers\StripeController;
use Slim\Routing\RouteCollectorProxy;

$app->group('/apiPrueba/', function(RouteCollectorProxy $group){
    $group->post('cargoNormal', StripeController::class.':crearCargo');//cargo a mi cuenta
    $group->post('cargoCuenta', StripeController::class.':cargoCuenta');//paga usuario a socio
    $group->post('pagoCliente', StripeController::class.':pago');//pago de usuario
    $group->post('crearCustomer', StripeController::class.':crearCustomer');//crear cliente
    $group->post('metodoPago', StripeController::class.':metodoPago');//crear metodo de pago
    $group->post('payment', StripeController::class.':payment');//otro metodo de pago
    $group->get('confirmar/{idConf}', StripeController::class.':confirmarCargo');//confirmar

    $group->post('prueba', StripeController::class.':prueba');//otro metodo de pago
});