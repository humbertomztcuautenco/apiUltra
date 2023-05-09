<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\StripeModel;


class StripeController{
    private $transaction=null;

    public function __construct(){
        $this->transaction = new StripeModel; 
    }

    public function crearCargo(Request $req, Response $res, array $args) {
        $parametros = json_decode($req->getBody()->getContents());


        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->transaction->crearCargo($parametros)));
            return $res;
    }
    

    public function cargoCuenta(Request $req, Response $res, $args) {
        $parametros = json_decode($req->getBody()->getContents());
        
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->transaction->cargoCuenta($parametros)));
            return $res;
    }

    public function pago(Request $req, Response $res, $args) {
        $parametros = json_decode($req->getBody()->getContents());
      
        
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->transaction->pago($parametros)));
            return $res;
    }

    public function crearCustomer(Request $req, Response $res, $args) {
        $parametros = json_decode($req->getBody()->getContents());
      
        
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->transaction->crearCustomer($parametros)));
            return $res;
    }
    public function metodoPago(Request $req, Response $res, $args) {
        $parametros = json_decode($req->getBody()->getContents());
        
        
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->transaction->metodoPago($parametros)));
            return $res;
    }
    public function payment(Request $req, Response $res, $args) {
        $parametros = json_decode($req->getBody()->getContents());
        
        
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->transaction->payment($parametros)));
            return $res;
    }

    public function confirmarCargo(Request $req, Response $res, $args) {
        $id=$args['idConf'];
        
        
        $res->withHeader('Content-type', 'application/json')
       
            ->getBody()->write(json_encode($this->transaction->confirmarCargo($id)));
            return $res;
    }
    public function prueba(Request $req, Response $res, $args) {
        $parametros = json_decode($req->getBody()->getContents());
        
        
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->transaction->createPaymentIntentOnConnect($parametros)));
            return $res;
    }

}