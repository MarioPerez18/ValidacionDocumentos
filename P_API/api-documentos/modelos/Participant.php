<?php

class Participant extends Conectar{
    
    public function all(){
        $conectar =  parent::conexion();
    
        parent::set_name();
    
        $sql = "SELECT * FROM participants";
        $sql = $conectar->prepare($sql);
        $sql->execute();
    
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function all_participants(){
        $conectar =  parent::conexion();
        parent::set_name();

        $sql1 = "SELECT participants.id, participants.apellidoPaterno as Apellido_Paterno, participants.apellidoMaterno as Apellido_Materno, 
        participants.nombres as Nombres, events.nombre as Evento,
        participanttypes.tipo as Tipo_Participante, events.fechaInicio, events.fechaTermino, institutions.nombreCorto as Instituto
        FROM (((participants
        INNER JOIN events ON participants.id = events.id) 
        INNER JOIN participanttypes ON participants.id = participanttypes.id)
        INNER JOIN institutions ON participants.id = institutions.id)";   
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute();
        return $sql1->fetchAll(PDO::FETCH_ASSOC);
    } 


    public function create($apellidoPaterno, $apellidoMaterno, $nombres, $genero, $telefono, $email, $institutions_id){
        $conectar =  parent::conexion();
        parent::set_name();

        $sql = "INSERT INTO participants (apellidoPaterno,apellidoMaterno,nombres,genero,telefono,email,institutions_id ) 
        VALUES (?,?,?,?,?,?,?)";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $apellidoPaterno);
        $sql->bindValue(2, $apellidoMaterno);
        $sql->bindValue(3, $nombres);
        $sql->bindValue(4, $genero);
        $sql->bindValue(5, $telefono);
        $sql->bindValue(6, $email);
        $sql->bindValue(7, $institutions_id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    
    //Tomar el ID del participante
    public function id_participante(){
        $conectar =  parent::conexion();
        parent::set_name();

        $sql = "SELECT id FROM participants";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>