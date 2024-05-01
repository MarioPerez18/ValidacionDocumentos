<?php

namespace modelos;
use Core\Conectar;
use PDO;

class EventParticipant extends Conectar{

    public function all(){
        $conectar =  parent::conexion();
        parent::set_name();

        $sql = "SELECT eventparticipants.id, participants.nombres, participants.apellidoPaterno, participants.apellidoMaterno, events.nombre AS Evento, events.descripcion, participanttypes.tipo, events.fechaTermino
        FROM (((eventparticipants
        INNER JOIN participants ON eventparticipants.participants_id = participants.id)
        INNER JOIN events ON eventparticipants.events_id = events.id)
        INNER JOIN participanttypes ON eventparticipants.participantTypes_id = participanttypes.id)
        ORDER BY participants.id";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update_document_id($id_documento){
        $conectar =  parent::conexion();
        parent::set_name();

        $sql = "UPDATE eventparticipants 
                SET documents_id = {$id_documento} 
                WHERE id = {$id_documento}";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

}