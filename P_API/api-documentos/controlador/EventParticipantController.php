<?php
namespace controlador;
use modelos\EventParticipant;
use modelos\Document;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, X-Api-Key");

class EventParticipantController{


    public function index(){
        $participante = new EventParticipant();
        $datos = $participante->all();
        http_response_code(202);
        return $datos;
    }

    //este método se va a encargar de actualizar el campo documents_id
    public function update(){
        $id_documento = new Document();
        $event_participant = new EventParticipant();

        $arreglo_id_documento = $id_documento->id_documento();
        $documento_id = array();
        foreach($arreglo_id_documento as $arr){
            $documento_id = $arr;
            $event_participant->update_document_id($documento_id["id"]);
        }
    }
}



