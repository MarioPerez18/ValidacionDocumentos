<?php

namespace Core;
use PDO;
use Exception;

class Conectar{
    protected $dbh;

    protected function conexion(){

        try{

            $conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=eventos", "root", "");
            return $conectar;

        }catch(Exception $e){
            echo "Error DB: " .$e->getMessage(). "<br>";

            die();
        }

    }

    //Metodo para establecer la codificacion de la BD
    public function set_name(){
        return $this->dbh->query("SET NAMES 'utf8'");
    }
}

?>