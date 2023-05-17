<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\AdminModel;

class AdminController{
    private $admin = null;

    public function __construct(){
        $this->admin = new AdminModel;
    }

//carrera
    public function crearCarrera(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->crearCarrera($parametros, $token)));
        return $res;
    }

    public function misCarreras(Request $req, Response $res, $args){
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->misCarreras($token)));
        return $res;
    }

    public function datosCarrera(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->datosCarrera($parametros, $token)));
        return $res;
    }

    public function delCarrera(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->delCarrera($parametros, $token)));
        return $res;
    }
//distancias
    public function distance(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->distance($parametros, $token)));
        return $res;
    }
    public function verDistance(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];
        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->verDistance($parametros,$token)));
        return $res;
    }
    public function actDistancia(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->actDistance($parametros, $token)));
        return $res;
    }

    public function delDistance(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->delDistance($parametros, $token)));
        return $res;
    }
    //avisos
    public function crearAviso(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->crearAviso($parametros, $token)));
        return $res;
    }
    public function actAviso(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->actAviso($parametros, $token)));
        return $res;
    }
    public function verAviso(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->verAviso($parametros, $token)));
        return $res;
    }
    public function delAviso(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->delAviso($parametros, $token)));
        return $res;
    }
    //acerca de
    public function addAcerca(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->addAcerca($parametros, $token)));
        return $res;
    }
    public function actAcerca(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->actAcerca($parametros, $token)));
        return $res;
    }
    public function verAcerca(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->verAcerca($parametros, $token)));
        return $res;
    }
    public function delAcerca(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->delAcerca($parametros, $token)));
        return $res;
    }
    public function addContact(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->addContact($parametros, $token)));
        return $res;
    }
    public function actContact(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->actContact($parametros, $token)));
        return $res;
    }
    public function verContacts(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->verContacts($parametros, $token)));
        return $res;
    }
    public function delContact(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->delContact($parametros, $token)));
        return $res;
    }

}