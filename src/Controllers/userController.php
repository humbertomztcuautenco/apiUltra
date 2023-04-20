<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\userModel;


class userController{
    private $user=null;

    public function __construct(){
        $this->user = new userModel; 
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

}