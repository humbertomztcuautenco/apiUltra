<?php
namespace App\Models;

use App\Models\BdModel,
    App\Lib\Response,
    App\Lib\Codigos,
    App\Lib\HasPass,
    App\Lib\Auth;

    class CorredorModel{
        private $db=null;
        private $response;
        private $tbPersona='persona';
        private $tbFavorito='favoritos';
        private $tbCarrera='datos_carrera';
        private $tbCorredor='corredor';

        public function __construct(){
            $db = new DbModel();
            $this -> db = $db->sqlPDO;
            $this -> response=new Response();
        }
        public function addCorredor($parametros, $persona){
            
            $validacion=$this->db->from($this->tbPersona)
                                    ->where('id',$persona)
                                    ->where('tipo_persona','1')
                                    ->fetch();              

            if($validacion){
                $id=$validacion['id'];
                $validacion2=$this->db->from($this->tbCorredor)
                                    ->where('persona_id',$id)
                                    ->fetch();
                if(!$validacion2){
                    $data=[
                        'genero'=>$parametros->genero,
                        'edad'=>$parametros->edad,
                        'tallaPlayera'=>$parametros->tallaPlayera,
                        'tipoSangre'=>$parametros->tipoSangre,
                        'condicionMedica'=>$parametros->condicion,
                        'seguro'=>$parametros->seguro,
                        'numeroPoliza'=>$parametros->numeroPoliza,
                        'tipoSeguros'=>$parametros->tipoSeguros,
                        'vigenciaPoliza'=>$parametros->VigenciaPoliza,
                        'persona_id'=>$persona
                    ];
                    $agregar=$this->db->insertInto($this->tbCorredor)
                                        ->values($data)
                                        ->execute();
                    
                    $this->response->result = null;
                        return  $this->response->SetResponse(true,"Se ha agregado el corredor ");
               
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"Ya existe este carredor");
                }
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"Parece que ha ocurrido un problema");

            }
        }
        public function inscribir($parametros,$persona){
            $validacion=$this->db->from($this->tbPersona)
                                    ->where('id',$parametros->id)
                                    ->where('tipo_persona','1')
                                    ->fetch();              

            if($validacion){
                $id=$validacion['id'];
                $validacion2=$this->db->from($this->tbCorredor)
                                    ->where('persona_id',$id)
                                    ->fetch();
                if(!$validacion2){
                    $data=[
                        'genero'=>$parametros->genero,
                        'edad'=>$parametros->edad,
                        'tallaPlayera'=>$parametros->tallaPlayera,
                        'tipoSangre'=>$parametros->tipoSangre,
                        'condicionMedica'=>$parametros->condicion,
                        'seguro'=>$parametros->seguro,
                        'numeroPoliza'=>$parametros->numeroPoliza,
                        'tipoSeguros'=>$parametros->tipoSeguros,
                        'vigenciaPoliza'=>$parametros->VigenciaPoliza,
                        'persona_id'=>$parametros->persona_id
                    ];
                    $agregar=$this->db->insertInto($this->tbCorredor)
                                        ->values($data)
                                        ->execute();
                    

                    $validacion3 = $this->db->from($this->tbCarrera)
                            ->where('id',$parametros->id)
                            ->fetch();

                    if($validacion3){
                        $data2=[
                            'corredor'=>$agregar['id'],
                            'datos_carrera'=>$validacion3['id']
                        ];
                        $agregar=$this->db->insertInto($this->tbInscripcion)
                                        ->values($data)
                                        ->execute();
                    }
                    
                }
            }
        }
    }