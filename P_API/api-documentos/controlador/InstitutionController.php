<?php

require_once("../Core/conexion.php");
require_once("../modelos/Institution.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, X-Api-Key");

class InstitutionController{

    public function index(){
        $institucion = new Institution();
        $datos = $institucion->all();
        //Convirtiendo los datos en formato PHP a formato JSON
        echo json_encode($datos);
        http_response_code(202);
    }
}


switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
      $result = new InstitutionController();
      $result->index();
      header('Content-Type: application/json');
      break;
    default:
      echo "El verbo usado es incorrecto";
}



?>