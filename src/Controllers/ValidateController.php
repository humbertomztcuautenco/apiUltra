<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\ValidateModel;

class ValidateController{
    private $valid = null;

    public function __construct(){
        $this->valid = new ValidateModel;
    }
    
    function validarEmail(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $res->withHeader('Content-type','application/json')
            ->getBody()->write(json_encode( $this->valid->validateE($parametros)));
        return $res;
    }
   
    function validarCodigo(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $res->withHeader('Content-type','application/json')
            ->getBody()->write(json_encode( $this->valid->validarCodigo($parametros)));
        return $res;
    }
    
    function registrarCliente(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $parametros->tipo_persona = 1;
        $res->withHeader('Content-type','application/json')
            ->getBody()->write(json_encode( $this->valid->regUsuario($parametros)));
        return $res;
    }
    
    function registrarAdmin(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $parametros->tipo_persona = 2;
        $res->withHeader('Content-type','application/json')
            ->getBody()->write(json_encode( $this->valid->regUsuario($parametros)));
        return $res;
    }
    
    function registrarStaff(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $parametros->tipo_persona = 3;
        $res->withHeader('Content-type','application/json')
            ->getBody()->write(json_encode( $this->valid->regUsuario($parametros)));
        return $res;
    }
    
    function auth(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->valid->auth($parametros)));
        return $res;
    }
   
    function enCodigoPassword(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->valid->enCodigoPassword($parametros)));
        return $res;
    }
   
    function vaCodigoPassword(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->valid->vaCodigoPassword($parametros)));
        return $res;
    }
   
    function recuperarPassword(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->valid->recuperarPassword($parametros)));
        return $res;
    }

    public function getUser(Request $req, Response $res, $args){
        $token = $args['token'];
        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->valid->getUser($token)));
        return $res;
    }
    public function getCodePais(Request $req, Response $res, $args){
        $res    ->withHeader('Content-type','application/json')
        ->getBody()->write(json_encode( $this->valid->getCodePais()));
        return $res;
    }
}