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
}