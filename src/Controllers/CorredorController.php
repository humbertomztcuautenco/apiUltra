<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\CorredorModel;

class CorredorController{
    private $corredor = null;

    public function __construct(){
        $this->corredor = new CorredorModel;
    }
    public function addCorredor(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->corredor->addCorredor($parametros,$token)));
        return $res;
    }
    public function inscribir(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->corredor->inscribir($parametros,$token)));
        return $res;
    }
    public function carrerasInsc (Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->corredor->carrerasInsc($parametros,$token)));
        return $res;
    }
}