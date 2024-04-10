<?php

class Document
{
    public function create($numero, $generado, $entregado, $archivo, $fechaGenerado, $fechaEntregado){
        
        $db_abstract_layer = new DBAbstractLayer();

        $result = $db_abstract_layer->add($numero, $generado, $entregado, $archivo, $fechaGenerado, $fechaEntregado);
        return $result; 
    }
}
