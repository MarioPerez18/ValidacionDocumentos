<?php

require_once("../Core/conexion.php");
require_once("../modelos/Participant.php");
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, X-Api-Key");

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
                                           $body["genero"], $body["telefono"], $body["correo"],
                                           $body["institucion"]);
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