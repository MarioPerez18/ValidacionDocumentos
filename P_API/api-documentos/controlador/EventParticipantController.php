<?php
require_once("../Core/conexion.php");
require_once("../modelos/EventParticipant.php");
require_once("../modelos/Document.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, X-Api-Key");

class EventParticipantController{


    public function index(){
        $participante = new EventParticipant();
        $datos = $participante->all();
        //Convirtiendo los datos en formato PHP a formato JSON
        echo json_encode($datos);
        http_response_code(202);
    }

    //este método se va a encargar de actualizar el campo documents_id
    public function update(){
        $id_documento = new Document();
        $event_participant = new EventParticipant();


        $arreglo_id_documento = $id_documento->id_documento();
        $documento_id = array();
        foreach($arreglo_id_documento as $arr){
            $documento_id = $arr;
        }
        $event_participant->update_document_id($documento_id["id"]);
    }
}

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
      $result = new EventParticipantController();
      $result->index();
      header('Content-Type: application/json');
      break;
    case "POST":
      $result = new EventParticipantController();
      $result->update();
      break;
    default:
      echo "El verbo usado es incorrecto";
}

