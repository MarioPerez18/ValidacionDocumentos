<?php

//header('Content-Type: application/json');

class DocumentController{

    private $cadena;
    private $vector_inicialiacion;
    private $passphrase;
    private $cipherMethod;

    public function __construct($cadena, $cipherMethod, $passphrase, $vector_inicialiacion)
    {
        $this->cadena = $cadena;
        $this->cipherMethod = $cipherMethod;
        $this->passphrase = $passphrase;
        $this->vector_inicialiacion = $vector_inicialiacion;
    }

   
    //Gettter y Setter
    public function getCadena(){
        return $this->cadena;
    }

    public function setCadena($cadena){
        $this->cadena = $cadena;
    }

    public function getVector(){
        return $this->vector_inicialiacion;
    }

    public function setVector($vector_inicialiacion){
        $this->vector_inicialiacion = $vector_inicialiacion;
    }

    public function getPassphrase(){
        return $this->passphrase;
    }

    public function setPassphrase($passphrase){
        $this->passphrase = $passphrase;
    }

    public function getCipherMethod(){
        return $this->cipherMethod;
    }

    public function setCipherMethod($cipherMethod){
        $this->cipherMethod = $cipherMethod;
    }

   
    //Funcion que decifra la cadena
    public function decifrar_cadena(){
        $decryptedData = openssl_decrypt($this->getCadena(), $this->getCipherMethod(), $this->getPassphrase(), OPENSSL_RAW_DATA, $this->getVector());
        return 'Cadena decifrada: ' . $decryptedData . PHP_EOL;
    }

    public function documento(){
        //ruta del documento
        $ruta_png = 'http://localhost:8080/api-documentos/static/documento/certificado.png';
        echo '<img src="'.$ruta_png.'" width=700/>'; 
    }
}

//Parametros que espera la funcion decifrar_cadena 
$cadena =  base64_decode($_GET["cadena"]);
$iv = base64_decode($_GET["iv"]);
$passphrase = 'ThePassword';
$cipherMethods = openssl_get_cipher_methods();
$cipherMethod = $cipherMethods[45];


$decifrar = new DocumentController($cadena, $cipherMethod, $passphrase, $iv);
$cadena_decifrada = $decifrar->decifrar_cadena();

echo $cadena_decifrada;
echo "<br>";
echo "<br>";
$decifrar->documento();

?>