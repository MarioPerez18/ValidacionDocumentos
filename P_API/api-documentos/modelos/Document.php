<?php

class Document extends Conectar
{

    public function create($numero, $generado, $entregado, $archivo, $fechaGenerado, $fechaEntregado){
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

    //Tomar el ID del documento
    public function id_documento(){
        $conectar =  parent::conexion();
        parent::set_name();

        $sql = "SELECT id FROM documents";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
