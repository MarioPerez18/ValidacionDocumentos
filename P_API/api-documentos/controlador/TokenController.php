<?php

namespace controlador;
use modelos\Token;
use modelos\Participant;
use Firebase\JWT\JWT;

class TokenController{

    public function store($body){
        $participantes = new Participant();
        $ids_participantes = $participantes->all_ids();
       

        $id_participante = array();
        foreach($ids_participantes as $id){
            $id_participante = $id;
        }
       
        $token = array(
            "id" => $id_participante["id"],
            "nombres" => $body["nombres"],
            "telefono" => $body["telefono"],
            "correo" => $body["correo"]
        );

        $jwt = JWT::encode($token, "eventositch", 'HS256');

        $tokens = new Token();
        $tokens->create($jwt, $id_participante["id"]);
        

    }

}