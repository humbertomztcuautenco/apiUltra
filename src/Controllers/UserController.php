<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\UserModel;

class UserController{
    private $user = null;

    public function __construct(){
        $this->user = new UserModel;
    }


    public function getInfo(Request $req, Response $res, $args){
        $token = $args['token'];
        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->user->getInfo($token)));
        return $res;
    }

    //favoritos
    public function addFavorito(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->user->addFavorito($parametros, $token)));
        return $res;
    }
    public function verFavorito(Request $req, Response $res, $args){
        
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->user->verFavorito($token)));
        return $res;
    }
    public function delFavorito(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->user->delFavorito($parametros,$token)));
        return $res;
    }
}