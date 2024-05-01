<?php

namespace controlador;
use modelos\Institution;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, X-Api-Key");

class InstitutionController{

    public function index(){
        $institucion = new Institution();
        $datos = $institucion->all();
        //Convirtiendo los datos en formato PHP a formato JSON
        http_response_code(202);
        return $datos;
       
    }
}






?>