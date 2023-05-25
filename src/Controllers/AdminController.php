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

    public function verCarreras(Request $req, Response $res, $args){
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->verCarreras($token)));
        return $res;
    }

    public function actCarrera(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->actCarrera($parametros, $token)));
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
    public function nombreDistancia(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->nombreDistancia($parametros, $token)));
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
    //turismo
    public function addTurismo(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->addTurismo($parametros, $token)));
        return $res;
    }
    public function actTurismo(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->actTurismo($parametros, $token)));
        return $res;
    }
    public function verTurismo(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->verTurismo($parametros, $token)));
        return $res;
    }
    public function delTurismo(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->delTurismo($parametros, $token)));
        return $res;
    }
    
    //boletos

    public function addBoleto(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->addBoleto($parametros, $token)));
        return $res;
    }
    public function verBoleto(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->verBoleto($parametros, $token)));
        return $res;
    }

    public function verBoleto2(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->verBoleto2($parametros, $token)));
        return $res;
    }

    public function actBoleto(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->actBoleto($parametros, $token)));
        return $res;
    }
    public function delBoleto(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());
        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->delBoleto($parametros, $token)));
        return $res;
    }

    //imagenes
    public function addImagen(Request $req, Response $res, $args){
        $parametros = $_POST;  // Datos del formulario
        $imagen = $_FILES['imagen'];  // Archivo de imagen

        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->addImagen($parametros,$imagen, $token)));
        return $res;
    }

    public function verImagen(Request $req, Response $res, $args){
        $parametros = json_decode($req->getBody()->getContents());

        $token = $args['token'];

        $res    ->withHeader('Content-type','application/json')
                ->getBody()->write(json_encode( $this->admin->verImagen($parametros, $token)));
        return $res;
    }
    

}