<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\PruebaModel;


class PruebaController{
    private $user=null;

    public function __construct(){
        $this->user = new PruebaModel; 
    }

    function registrarUsuario(Request $req, Response $res, $arg){
        
        $parametros = json_decode($req->getBody()->getContents());
      
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->user->registrarUsuario($parametros)));

        return $res;
    }

    function leerUsuarios(Request $req, Response $res, $arg){
      
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->user->leerUsuarios()));

        return $res;
    }

    function actualizarUsuario(Request $req, Response $res, $arg){
        $id=$arg['idusers'];
        $parametros = json_decode($req->getBody()->getContents());
        
      
        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->user->actualizarUsuario($id, $parametros)));

        return $res;
    }

    function eliminarUsuario(Request $req, Response $res, $arg){
        $id=$arg['idusers'];

        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->user->eliminarUsuario($id)));
            return $res;
    }

    function leerUsuario(Request $req, Response $res, $arg){
        $id=$arg['idusers'];

        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->user->leerUsuario($id)));
            return $res;
    }

    function validar(Request $req, Response $res, $arg){
        $parametros = json_decode($req->getBody()->getContents());

        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->user->validar($parametros)));
            return $res;
    }

    public function pagar(Request $request, Response $response, $args) {
        $stripe = new \Stripe\StripeClient($_ENV['Clave_secreta']);
        
        $baseUrl = $request->getAttribute('base_url');

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'T-shirt',
                    ],
                    'unit_amount' => 2000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' =>  'http://localhost:8000/apiPrueba/success',
            'cancel_url' =>  'http://localhost:8000/apiPrueba/cancel',
        ]);

        return $response
            ->withHeader('Location', $checkout_session->url)
            ->withStatus(303);
    }

    public function password (Request $req, Response $res, $arg){
        $data = json_decode($req->getBody()->getContents());

        $res->withHeader('Content-type', 'application/json')
            ->getBody()->write(json_encode($this->user->password($data)));
            return $res;
    }

      
      
}