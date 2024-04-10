<?php

require_once("../Core/conexion.php");
require_once("../modelos/Participant.php");
require_once("../Core/DBAbstractLayer.php");
header('Content-Type: application/json');

class ParticipantController{

    public function index(){
        $participante = new Participant();
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $datos = $participante->all();
            //Convirtiendo los datos en formato PHP a formato JSON
            echo json_encode($datos);
            http_response_code(202);
        }
    }

    public function store(){
        $body = json_decode(file_get_contents("php://input"), true);
        $participante = new Participant();
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $participante->create($body["apellidoPaterno"], $body["apellidoMaterno"], $body["nombres"], 
                                           $body["genero"], $body["telefono"], $body["email"],
                                           $body["institutions_id"] );
            //Convirtiendo los datos en formato PHP a formato JSON
            echo json_encode("Insertado correctamente");
            http_response_code(201);
        }
    }
}

$result = new ParticipantController();
$result->index();
$result->store();
?>