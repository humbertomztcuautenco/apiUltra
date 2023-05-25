<?php
namespace App\Models;

use App\Models\BdModel,
    App\Lib\Response,
    App\Lib\ResponseAuth,
    App\Lib\HasPass,
    App\Lib\Codigos,
    App\Lib\Auth;



class ValidateModel{
    private $db=null;
    private $response;
    private $responseA;
    private $tbUser='persona';
    private $tbCodigos='codigos_validacion';
    private $tbRecuperarPassword='codigos_recover_password';
    private $tbPaises;

    public function __construct(){
        $db = new DbModel();
        $this -> db = $db->sqlPDO;
        $this -> response=new Response();
    }

    public function validateE($parametros){
        $email=$parametros->email;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->response->result = null;
            return  $this->response->SetResponse(false,'El correo no es valido use el formato ejemplo@dominio.com.');
        } 
        $validacion = $this->db->from($this->tbUser)
                            ->where('correo',$email)
                            ->where('tipo_persona',$parametros->tipo_persona)
                            ->fetch();

        $validacion2=$this->db->from($this->tbCodigos)
                            ->where('correo',$email)
                            ->where('tipo_persona',$parametros->tipo_persona)
                            ->fetch();

        if (!$validacion) {

            if(!$validacion2){
                $codigo = Codigos::generar(6);
                $fechaEx = time() + (24 * 60 * 60);
                $data = [
                    'codigo'            => $codigo,
                    'correo'             => $email,
                    'status'            => 'active',
                    'fechaExpiracion'   => $fechaEx,
                    'tipo_persona'      => $parametros->tipo_persona
                ];
                
                $insertCode = $this->db->insertInto($this->tbCodigos)
                                    ->values($data)
                                    ->execute();
            }else{
                $codigo = Codigos::generar(6);
                $fechaEx = time() + (24 * 60 * 60);
                $data = [
                    'codigo'            => $codigo,
                    'status'            => 'active',
                    'fechaExpiracion'   => $fechaEx
                ];
                
                $insertCode = $this->db->update($this->tbCodigos)
                                    ->where('correo',$email)
                                    ->where('tipo_persona',$parametros->tipo_persona)
                                    ->set($data)
                                    ->execute();
            }
            
            

            
            /*$subject='Envio de codigo';
            $message='Envio de codigo de registro para "Ultra App"'.$codigo;
            $headers='From: Prueba codigo :D';

            if (mail($email, $subject, $message, $headers)) {*/
                            $this->response->result = null;
                            return  $this->response->SetResponse(true,"Se envio un codigo a la cuenta $email con caducidad de 24 horas.");
            /*}else{
                $this->response->result = null;
               return  $this->response->SetResponse(false,'El correo no se pudo enviar.');
            }   */        
        }else{
                    $this->response->result = null;
            return  $this->response->SetResponse(false,'La cuenta ya existe.');
        }

    }

    public function validarCodigo($parametros){
        
        $code = $parametros->codigo;
        $email = $parametros->correo;
        $tipo_persona = $parametros->tipo_persona;
        $fecha = time();
       
        $getCode = $this->db->from($this->tbCodigos)
                         ->where('codigo',$code)
                         ->where('status','active')
                         ->where('fechaExpiracion >= ?',$fecha)
                         ->where('correo',$email)
                         ->where('tipo_persona',$tipo_persona)
                         ->orderBy('id DESC')
                         ->fetch();

        if ($getCode) {
            // update campo de codigo
            $this->db->update($this->tbCodigos)
                        ->set(array('status' => 'inactive'))
                        ->where('id = ?', $getCode['id'])
                        ->execute();
            // generar token de validacion
            $tokenReg = Auth::TokReg($getCode);
                    $this->response->result = $tokenReg;
            return  $this->response->SetResponse(true,'Codigo encontrado.');
        } else {
                    $this->response->result = null;
            return  $this->response->SetResponse(false,'Codigo no valido.');
        }
    }

    public function regUsuario($parametros){

        $dupli=$this->db->from($this->tbUser)
                        ->where('correo',$parametros->correo)
                        ->fetch();
        if (!$dupli) {
            $data = [
                'nombre'=>$parametros->nombre,
                'apellidoPaterno'=>$parametros->apellidoPaterno,
                'apellidoMaterno'=>$parametros->apellidoMaterno,
                'correo'=>$parametros->correo,
                'pasword'=>$parametros->pasword,
                'numeroTelefono'=>$parametros->numeroTelefono,
                'status'=>'activo',
                'pais'=>$parametros->pais,
                'tipo_persona'=>$parametros->tipo_persona

            ];
            $data['pasword'] = HasPass::hash($data['pasword']);
            $registro = $this->db->insertInto($this->tbUser,$data)
                    ->execute();
            if ($registro != null) {
                $this->response->result = $parametros;
                return  $this->response->SetResponse(true,'Usuario registrado.');
            }else{
                $this->response->result = $registro;
                return  $this->response->SetResponse(false,'Usuario no registrado.');
            }
        }
        
    }



    public function auth($parametros){
      
        
        $authUser = $this->db->from($this->tbUser)
                         ->where('correo',$parametros->correo)
                         ->where('tipo_persona',$parametros->tipo_persona)
                         ->fetch();

        if ($authUser != null) {
            $validarPassword = password_verify($parametros->pasword, $authUser['pasword']);
            if(!$validarPassword) 
            return $this->response->SetResponse(false,'Contraseña incorrecta.');
            $token = Auth::addToken($authUser);
                    $this->response->result = ['token'=>$token,'id'=>$authUser['id']];
                    
            return  $this->response->SetResponse(true,'Inicio de sesion correcto');
        }else{
                    
            return  $this->response->SetResponse(false,'Correo incorrecto.');
        }                 
        
    }

    public function enCodigoPassword($parametros){
        
        $user = $this->db->from($this->tbUser)
                 ->where('correo',$parametros->correo)
                 ->where('tipo_persona',$parametros->tipo_persona)
                 ->fetch();
        $id=$user['id'];

        $validar = $this->db->from($this->tbRecuperarPassword)
                 ->where('persona_id',$id)
                 ->fetch();
        

        if($user == null) return  $this->response->SetResponse(false,'El usuario no se encontro.');

        if(!$validar){
            $codigo = Codigos::generar(6);
            $fechaEx = time() + (24 * 60 * 60);
        

            $data = [
                'codigos'            => $codigo,
                'status'            => 'active',
                'fechaExpiracion'   => $fechaEx,
                'persona_id'      => $id
            ];

            $altaCode = $this->db->insertInto($this->tbRecuperarPassword)
                                ->values($data)
                                ->execute();
        }else{
            $codigo = Codigos::generar(6);
            $fechaEx = time() + (24 * 60 * 60);
        

            $data = [
                'codigos'            => $codigo,
                'status'            => 'active',
                'fechaExpiracion'   => $fechaEx,
            ];
            $altaCode = $this->db->update($this->tbRecuperarPassword)
                                ->where('persona_id',$id)
                                ->set($data)
                                ->execute();
        }

                $this->response->result = null;
        return  $this->response->SetResponse(true,"Se envio un codigo a la cuenta {$user['correo']} con caducidad de 24 horas.");
                        
    }

    public function vaCodigoPassword($parametros){
        $codigo = $parametros->codigo;
        $correo = $parametros->correo;
        $tipo_persona = $parametros->tipo_persona;
        $fecha = time();
        // get user
        $user = $this->db->from($this->tbUser)
                 ->where('correo',$correo)
                 ->where('tipo_persona',$tipo_persona)
                 ->fetch();

        if($user == null) return  $this->response->SetResponse(false,'El usuario no se encontro.');
        // 
        $getCode = $this->db->from($this->tbRecuperarPassword)
                         ->where('codigos',$codigo)
                         ->where('status','active')
                         ->where('fechaExpiracion >= ?',$fecha)
                         ->where('persona_id',$user['id'])
                         ->orderBy('id DESC')
                         ->fetch();
        if ($getCode) {
            
            $this->db->update($this->tbRecuperarPassword)
                        ->set(array('status' => 'inactive'))
                        ->where('id = ?', $getCode['id'])
                        ->execute();
            
            $tokenRecover = Auth::tokRecPass($getCode);
                    $this->response->result = $tokenRecover;
            return  $this->response->SetResponse(true,'Codigo encontrado.');
        } else {
                    $this->response->result = null;
            return  $this->response->SetResponse(false,'Codigo no valido.');
        }
    }

    public function recuperarPassword($parametros){
        $correo = $parametros->correo;
        $tipo_persona = $parametros->tipo_persona;
        $password = $parametros->password;

        $user = $this->db->from($this->tbUser)
                            ->where('correo ',$correo)
                            ->where('tipo_persona',$tipo_persona)
                            ->fetch();
        
        if($user == null) return  $this->response->SetResponse(false,'El usuario no se encontro.');
        
        $password = HasPass::hash($password);
        $this->db->update($this->tbUser)
                ->set(array('pasword' => $password))
                ->where('correo',$correo)
                ->where('tipo_persona',$tipo_persona)
                ->execute();

                $this->response->result = null;
        return  $this->response->SetResponse(true,'Password actualizada.');
    }

    public function getUser($token){
        $res = auth::decData($token);
        if ($res == null) return $this->response->SetResponse(false,"No hay datos.");
                $this->response->result = $res;
        return  $this->response->SetResponse(true,'Informacion de user.');
    }


    public function getCodePais() {
        $extencionPais = $this->db->from($this->tbPaises)
                 ->fetchAll();
                 $this->response->result = $extencionPais;
         return  $this->response->SetResponse(true,'Lista de codigos de paises');

    }

    public function validarToken($data){
        //$token=new Auth();
        $res=auth::validateToken($data);
        if(!$res){
            $this->response->errors="Token incorrecto";
            return $this->response->SetResponse(false);
        }
        $this->response->result=$res;
        return $this->response->SetResponse(true,"Token correcto");
    }
}