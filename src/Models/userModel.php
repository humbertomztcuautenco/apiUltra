<?php
namespace App\Models;

use App\Models\bdModel,
    App\Lib\Response;

    class userModel{
        private $db=null;
        private $response;
        private $tbUser='users';

        public function __construct(){
            $db = new dbModel();
            $this->db=$db->sqlPDO;
            $this->response=new Response();
        }

        public function registrarUsuario($parametros){

            $data=get_object_vars($parametros);
            $registro = $this->db->insertInto($this->tbUser,$data)
                                ->execute();

            if ($registro != null) {
                    $this->response->result = $parametros;
                    return  $this->response->SetResponse(true,'Usuario registrado.');
            }else{
                    $this->response->result = $registro;
                    return  $this->response->SetResponse(false,'Usuario no regirstrado.');
            }
            
        }


        public function leerUsuarios(){
            $leer = $this->db->from($this->tbUser);
            return $leer->fetchAll();

            
            if ($leer != null) {
                    $this->response->result = $leer;
                    return  $this->response->SetResponse(true,'Consulta realizada.');
            }else{
                    $this->response->result = $leer;
                    return  $this->response->SetResponse(false,'Consulta no realizada.');
            }
        }

        public function actualizarUsuario($id,$parametros){
            $existe=$this->db->from($this->tbUser)
                                ->where('idusers', $id)
                                ->fetch();
            if($existe == null) return  $this->response->SetResponse(false,'El usuario no se encontro.');


            $data=get_object_vars($parametros);
            $actualizar = $this->db->update($this->tbUser)
                                    ->set($data)
                                    ->where('idusers',$id)
                                    ->execute();
            $this->response->result = $actualizar;
            return  $this->response->SetResponse(true,'usuario actualizado.');
            
        }


        public function eliminarUsuario($id){
            $existe=$this->db->from($this->tbUser)
                                ->where('idusers', $id)
                                ->fetch();
            if($existe == null) return  $this->response->SetResponse(false,'El usuario no se encontro.');

            
            $eliminar = $this->db->delete($this->tbUser)
                                    ->where('idusers',$id)
                                    ->execute();
            $this->response->result = $eliminar;
            return  $this->response->SetResponse(true,'Consulta realizada.');

            
        }


        public function leerUsuario($id){
            $leer = $this->db->from($this->tbUser)
            ->where('idusers',$id)
            ->fetch();

            
            if ($leer != null) {
                    $this->response->result = $leer;
                    return  $this->response->SetResponse(true,'Consulta realizada.');
            }else{
                    $this->response->result = $leer;
                    return  $this->response->SetResponse(false,'Usuario no encontrado.');
            }
        }

    }