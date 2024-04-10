<?php

class DBAbstractLayer extends Conectar
{

    public function all(){
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


    public function add($numero, $generado, $entregado, $archivo, $fechaGenerado, $fechaEntregado){
        $conectar =  parent::conexion();
        parent::set_name();

        $sql = "INSERT INTO documents (numero, generado, entregado, archivo, fechaGenerado, fechaEntregado) VALUES (?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $numero);
        $sql->bindValue(2, $generado);
        $sql->bindValue(3, $entregado);
        $sql->bindValue(4, $archivo);
        $sql->bindValue(5, $fechaGenerado);
        $sql->bindValue(6, $fechaEntregado);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);

    }
}
