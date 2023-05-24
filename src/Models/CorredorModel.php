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
        private $tbInscripcion='inscripcion';

        public function __construct(){
            $db = new DbModel();
            $this -> db = $db->sqlPDO;
            $this -> response=new Response();
        }

        public function validar($persona){
             $validacion=$this->db->from($this->tbPersona)
                                    ->where('id',$persona)
                                    ->where('tipo_persona','1')
                                    ->fetch();              

            if($validacion){
                $id=$validacion['id'];
                $validacion2=$this->db->from($this->tbCorredor)
                                    ->where('persona_id',$id)
                                    ->fetch();
                return $validacion2['id'];
            }
        }
        public function addCorredor($parametros, $persona){

            $validacion=self::validar($persona); 

                if(!$validacion){
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
                    
                    $this->response->result = $agregar['id'];
                        return  $this->response->SetResponse(true,"Se ha agregado el corredor ");
               
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"Ya existe este carredor");
                }
        }
        public function inscribir($parametros,$persona){
            $validacion=self::validar($persona);   
            
            $validacion2 = $this->db->from($this->tbCarrera)
                            ->where('id',$parametros->id)
                            ->fetch();  

            if($validacion && $validacion2){
                $data=[
                    'corredor'=>$validacion,
                    'datos_carrera'=>$validacion2['id']
                ];
                $agregar=$this->db->insertInto($this->tbInscripcion)
                                ->values($data)
                                ->execute();
                $this->response->result = null;
            return  $this->response->SetResponse(true,"Se ha inscrito correctamente");
            }else{
                $this->response->result = null;
                return  $this->response->SetResponse(false,"ha ocurrido un problema");
            }
            
        }

        public function carrerasInsc($parametros,$persona){
            $validacion=self::validar($persona);

            $leer2=$this->db->from($this->tbInscripcion)
                            ->select('inscripcion.corredor, datos_carrera.nombreCarrera, datos_carrera.lugar')
                            ->innerJoin('datos_carrera ON inscripcion.datos_carrera=datos_carrera.id')
                            ->where('corredor',$validacion)
                            ->fetchAll();
                            return $leer2;
        }
    }