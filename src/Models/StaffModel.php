<?php
namespace App\Models;

use App\Models\BdModel,
    App\Lib\Response,
    App\Lib\Codigos,
    App\Lib\HasPass,
    App\Lib\Auth;

    class StaffModel{
        private $db=null;
        private $response;
        private $tbCarrera='datos_carrera';
        private $tbDistancia='distancia';
        private $tbAviso='avisos';
        private $tbAcerca='acerca_de';
        private $tbContacto='contacto_carrera';
        private $tbTurismo='turismo';
        private $tbPersona='persona';

        public function __construct(){
            $db = new DbModel();
            $this -> db = $db->sqlPDO;
            $this -> response=new Response();
        }

        public function verStaff($parametros, $persona){
            $validacion = $this->db->from($this->tbCarrera)
                            ->where('nombreCarrera',$parametros->nombre)
                            ->where('persona_id',$persona)
                            ->fetch();
            
            if($validacion){
                $id=$validacion['id'];
                $leer = $this->db->from($this->tbPersona)
                                    ->where('',$id)
                                    ->fetchAll();
                if($leer){
                    $this->response->result = $leer;
                    return  $this->response->SetResponse(true,"'Acerca de' de la carrera {$parametros->nombre}");
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(false,"Parece que aun no tienes algun 'Acerca de' en esta carrera");
                }
            }else{
                return  $this->response->SetResponse(false,"Parece que la carrera no existe");
            }
        }
    }