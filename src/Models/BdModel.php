<?php
namespace App\Models;

use PDO;

class DbModel{
    public $sqlPDO=null;
    public function __CONSTRUCT(){
        try{
            $host = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_NAME'];
            $username = $_ENV['DB_USER'];
            $password =$_ENV['DB_PASSWORD'];
            $charset = 'utf8mb4';
            $dns = "mysql:host=$host;dbname=$dbname;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_SSL_CA => "/etc/ssl/certs/ca-certificates.crt",

            ];
            $pdo= new PDO($dns, $username, $password, $options);

            $this->sqlPDO = new \Envms\FluentPDO\Query($pdo);
        }catch (\Exception $e){

            return $e->getMessage();
        }
    }
}

