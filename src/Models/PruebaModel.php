<?php
namespace App\Models;

use App\Models\BdModel,
    App\Lib\Response,
    App\Lib\Codigos,
    App\Lib\HasPass;

    class PruebaModel{
        private $db=null;
        private $response;
        private $tbUser='users';
        private $tbUser3='usu5';

        public function __construct(){
            $db = new DbModel();
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

        public function validar($parametros){
            $password=HasPass::hash($parametros->password);
            $tipoUsser = $parametros->tipoUsser;
            $email = $parametros->email;
            $name = $parametros->name;
            $secondName = $parametros->secondName;
            
    
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $this->response->result = null;
                return  $this->response->SetResponse(false,'El correo no es valido use el formato ejemplo@dominio.com.');
            } 
            $validacion = $this->db->from($this->tbUser3)
                                   ->where('name',$name)
                               
                                   ->fetch();
    
            if (!$validacion) {
                
                $codigo = Codigos::generar(6);
                $data = [
                    'codigo'        => $codigo,
                    'email'         => $email,
                    'name'          => $name,
                    'secondName'    => $secondName,
                    'password'      => $password,
                    'tipoUsser'     => $tipoUsser
                ];

                $insertCode = $this->db->insertInto($this->tbUser3)
                                       ->values($data)
                                       ->execute();
                
                
                            $this->response->result = null;
                    return  $this->response->SetResponse(true,"Se envio un codigo a la cuenta $email con caducidad de 24 horas");
                
            }else{
                        $this->response->result = null;
                return  $this->response->SetResponse(false,'La cuenta ya existe.');
            }
        }

        public function password ($data){
            $data2= HasPass::hash($data->password);

            return ['contraseña1' => $data,
            'contraseña' => $data2];


        }

    }