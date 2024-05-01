<?php

namespace controlador;
use modelos\Participant;
use controlador\TokenController;
//header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


class ParticipantController{

    public function index(){
        $participante = new Participant();
        $datos = $participante->all();
        //Convirtiendo los datos en formato PHP a formato JSON
        http_response_code(202);
        return $datos;
    }

    public function store(){
        $body = json_decode(file_get_contents("php://input"), true);
        $participante = new Participant();
        $participante->create($body["apellidoPaterno"], $body["apellidoMaterno"], $body["nombres"], 
                                        $body["genero"], $body["telefono"], $body["correo"],
                                        $body["institucion"]);
            //Convirtiendo los datos en formato PHP a formato JSON
            echo json_encode("Insertado correctamente");
            http_response_code(201);
            $controlador_token = new TokenController();
            $controlador_token->store($body);

    }
}


?>