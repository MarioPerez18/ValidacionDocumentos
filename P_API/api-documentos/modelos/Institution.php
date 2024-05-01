<?php

namespace modelos;
use Core\Conectar;
use PDO;

class Institution extends Conectar{
    
    public function all(){
        $conectar =  parent::conexion();
    
        parent::set_name();
    
        $sql = "SELECT id, nombreCorto, nombreLargo FROM institutions";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

}


?>