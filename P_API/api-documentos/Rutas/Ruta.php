<?php

namespace Rutas;

class Ruta{

    //se iran agregando las rutas al arreglo
    private static $rutas = [];

    public static function get($uri, $callback){
        $uri = trim($uri, '/');
        self::$rutas['GET'][$uri] = $callback;
    }

    public static function post($uri, $callback){
        $uri = trim($uri, '/');
        self::$rutas['POST'][$uri] = $callback;
    }

    public static function dispatch(){
        $uri = $_SERVER['REQUEST_URI'];
        $uri = trim($uri, '/');

        $verbo = $_SERVER['REQUEST_METHOD'];

        if ($verbo === 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
            header('Access-Control-Allow-Headers: token, Content-Type');
            die();
        }

        foreach(self::$rutas[$verbo] as $route => $callback){

            if(strpos($route, ':') != false){
                $route = preg_replace('#:[a-zA-Z\d\%]+#', '([a-zA-Z\d\%]+)', $route);
            }

           
            if(preg_match("#^$route$#", $uri, $matches)){
                
                $params = array_slice($matches, 1);
                //$response = $callback(...$params);
                if(is_callable($callback)){
                    $response = $callback(...$params);
                }

                if(is_array($callback)){
                    $controlador = new $callback[0];
                    $response = $controlador->{$callback[1]}(...$params);
                }


                if(isset($response)){
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
                return;
            }
        }
        echo json_encode("Recurso No Encontrado");
        http_response_code(404);
    }
}