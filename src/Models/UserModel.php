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
        private $tbPaises;

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

        
    }