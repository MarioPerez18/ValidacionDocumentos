<?php

class Participant{

    public function get_participants(){
        $db_abstract_layer = new DBAbstractLayer();

        $result = $db_abstract_layer->all();
        return $result; 
    }
}