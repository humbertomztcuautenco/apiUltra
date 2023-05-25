<?php
namespace App\Models;

use App\Models\BdModel,
    App\Lib\Response,
    App\Lib\Codigos,
    App\Lib\HasPass,
    App\Lib\Auth;

    class UserModel{
        private $db=null;
        private $response;
        private $tbUser='persona';
        private $tbFavorito='favoritos';
        private $tbCarrera='datos_carrera';

        public function __construct(){
            $db = new DbModel();
            $this -> db = $db->sqlPDO;
            $this -> response=new Response();
        }

        public function getInfo($token){
            $res = auth::decData($token);
             if ($res == null) return $this->response->SetResponse(false,"No hay datos.");

                $this->response->result = $res->id;
                return  $this->response->SetResponse(true,'id.');
        }
        

        public function addFavorito($parametros, $persona){
            $validacion = $this->db->from($this->tbCarrera)
                                ->where('id',$parametros->id)
                                ->fetch();
                
            if($validacion){
                $validacion2 = $this->db->from($this->tbFavorito)
                                        ->where('datos_carrera',$parametros->id)
                                        ->where('persona', $persona)
                                        ->fetch();
                if(!$validacion2){
                    $data = [
                    'datos_Carrera'    => $parametros->id,
                    'persona'            => $persona
                    ];
                    
                    $insertCode = $this->db->insertInto($this->tbFavorito)
                                            ->values($data)
                                            ->execute();
                
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"añadido a favoritos");
                }else{
                    return  $this->response->SetResponse(true,"esta carrera ya está en favoritos");
                }
                
            }else{
                return  $this->response->SetResponse(true,"ha ocurrido un error");
            }
        }

        public function verFavorito($persona){

            $leer2=$this->db->from($this->tbFavorito)
                            ->select('favoritos.persona, datos_carrera.nombreCarrera, datos_carrera.lugar')
                            ->innerJoin('datos_carrera ON favoritos.datos_carrera=datos_carrera.id')
                            ->where('persona',$persona)
                            ->fetchAll();

            if ($leer2) {
                $this->response->result = $leer2;
                return $this->response->SetResponse(true, "favoritos existentes");
            } else {
                $this->response->result = null;
                return $this->response->SetResponse(true, "Parece que aún no tienes favoritos");
            }
            
        }

        public function delFavorito($parametros, $persona){
            $validacion = $this->db->from($this->tbCarrera)
                                ->where('id',$parametros->id)
                                ->fetch();
                
            if($validacion){
                $validacion2 = $this->db->from($this->tbFavorito)
                                        ->where('datos_carrera',$parametros->id)
                                        ->where('persona', $persona)
                                        ->fetch();
                if($validacion2){
                    $data = [
                    'datos_Carrera'    => $parametros->id,
                    'persona'            => $persona
                    ];
                    
                    $delete=$this->db->delete($this->tbFavorito)
                                        ->where('datos_carrera',$parametros->id)
                                        ->where('persona',$persona)
                                        ->execute();
                
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"eliminado de favoritos");
                }else{
                    return  $this->response->SetResponse(true,"ya no exite esta carrera en favoritos");
                }
                
            }else{
                return  $this->response->SetResponse(true,"ha ocurrido un error");
            }
        }
        public function carreras(){
            $carrera=$this->db->from($this->tbCarrera)
                           ->select('id, nombreCarrera, fecha, lugar','id')
                           ->fetchAll();
            return $carrera;
        }
        
    }