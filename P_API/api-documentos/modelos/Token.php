<?php

namespace modelos;
use Core\Conectar;
use PDO;

class Token extends Conectar{
    
   
    public function create($cadenaToken, $participant_id){
        $conectar =  parent::conexion();
        parent::set_name();

        $sql = "INSERT INTO tokens (cadenaToken, participants_id ) 
        VALUES (?,?)";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cadenaToken);
        $sql->bindValue(2, $participant_id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }


}