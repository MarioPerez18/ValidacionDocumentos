<?php

namespace controlador;
use Exception;
use modelos\Document;
use controlador\EventParticipantController;
use QRCode;
use FPDF;


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, X-Api-Key");


class DocumentController{

    private $passphrase;
    private $cipherMethod;
    public $jsonencript;
    private $nombre_archivo;
    private $folio_documento;
 
   
    public function __construct()
    {
        $cipherMethods = openssl_get_cipher_methods();
        $this->cipherMethod = $cipherMethods[45];
        $this->passphrase = 'ThePassword';
    }

   
    //Gettter y Setter
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

    public function getNombreArchivo(){
        return $this->nombre_archivo;
    }

    public function setNombreArchivo($nombre_archivo){
        $this->nombre_archivo = $nombre_archivo;
    }

    public function getFolioDocumento(){
        return $this->folio_documento;
    }

    public function setFolioDocumento($folio_documento){
        $this->folio_documento = $folio_documento;
    }

    

    //método que recibe los datos.
    public function index(){
        $body = json_decode(file_get_contents("php://input"), true);
        $this->cifrar_datos($body);
        return $body;
    }

    //método que creará la cadena.
    public function cifrar_datos($datos){
        $this->jsonencript = json_encode($datos);
        
        //generación del iv.
        try {
            //obtiene la longitud del cifrado iv.
            $inicializationVectorLength = openssl_cipher_iv_length($this->getCipherMethod());
        } catch (Exception $e) {
            echo 'ERROR getting IV length, using 256' . PHP_EOL;
            $inicializationVectorLength = 256;
        }
        //genera una cadena pseudoaleatoria de bytes.
        $inicializationVector = openssl_random_pseudo_bytes($inicializationVectorLength);
        $iv = base64_encode($inicializationVector);
       
        
        //crifrar datos.
        $encryptedData = base64_encode(openssl_encrypt($this->jsonencript, $this->getCipherMethod(), $this->getPassphrase(), OPENSSL_RAW_DATA, $inicializationVector));
        $url = 'http://eventos.itchetumal.edu.mx:8080/validacion/' . urlencode($encryptedData) . '/' . urlencode($iv);
        return $url;
    }

    //método que decifra la cadena.
    public function decifrar_cadena($cadena, $iv){
        $decryptedData = openssl_decrypt($cadena, $this->getCipherMethod(), $this->getPassphrase(), OPENSSL_RAW_DATA, $iv);
        return $decryptedData . PHP_EOL;
    }

    public function documento(){
        //ruta del documento
        $ruta_png = 'http://localhost:8080/api-documentos/static/documento/certificado.png';
        echo '<img src="'.$ruta_png.'" width=700/>'; 
    }


    //método que generará el codigo Qr.
    public function generar_qrcode($url){
        //nombre y ruta del png
        $nombre_png = uniqid().'.png';
        $ruta_png_QRcode = './static/img'.'/'.$nombre_png;
        $this->setFolioDocumento($nombre_png);
        QRcode::png($url, $ruta_png_QRcode);
        //echo $url;
        return $ruta_png_QRcode;
    }

    //método que generará el pdf.
    public function generar_pdf($QRcode){
        //registro de la peticion
        $registro = $this->index();

        //nombre y ruta del archivo pdf
        $nombre_pdf = "{$registro["Evento"]}_{$registro["Nombres"]}.pdf";
        $this->setNombreArchivo($nombre_pdf);
        $ruta_pdf ='./static/PDF/' . $nombre_pdf;
        //ruta del png
        $ruta_png = './static/documento/TEC.png';

        //ruta de los logos del tecnm
        $ruta_png_itch = './static/logos_tec/logoItch.png';
        $ruta_png_tecnm = './static/logos_tec/tecnm.png';

        //crear pdf
        $pdf = new FPDF();
        $pdf->AddPage('horizontal');
        $pdf->Image($ruta_png, 0, 0, 300, 210,'PNG');
        $pdf->Image($QRcode,  141, 170, 30, 30,'PNG');
        $pdf->Image($ruta_png_tecnm,  220, 5, 40, 20,'PNG');
        $pdf->Image($ruta_png_itch,  258, 5, 30, 20,'PNG');
        $pdf->SetFont('Arial','',20);
        $pdf->SetXY(76,88);
        $pdf->Cell(161, 10,  utf8_decode("{$registro["Nombres"]} {$registro["ApellidoPaterno"]} {$registro["ApellidoMaterno"]}"), 0, 0, 'C');
        $pdf->SetFont('Arial','',15);
        $pdf->SetXY(76,102);
        $pdf->MultiCell(161, 7, utf8_decode("Por su participación como {$registro["TipoParticipante"]} en el evento {$registro["Evento"]}: {$registro["Descripcion"]}") , 0, 'C', 0);
        $pdf->SetFont('Arial','',10);
        $pdf->SetXY(76,160);
        $pdf->MultiCell(161, 3,  utf8_decode("Fecha de finalización : {$registro["FechaTermino"]}hrs"), 0, 'C', 0);

        // Guardar el archivo pdf en la carpeta especificada
        $pdf->Output('F', $ruta_pdf, true);
    }  

   

    //método que guardará el registro creado.
    public function cifrado(){
        $documents = new Document();
        //Separar el número de la extension png
        $folio_documento = explode('.', $this->getFolioDocumento());
        $numero =  $folio_documento[0];
        //verificar si el archivo existe
        $generado = (file_exists('./static/PDF/'.$this->getNombreArchivo()) ? True : False );
        $entregado = true;
        $archivo = $this->getNombreArchivo();
        $fechaGenerado = date('Y-m-d H:i:s');
        $fechaEntregado = date('Y-m-d H:i:s');
        $documents->create($numero, $generado, $entregado, $archivo, $fechaGenerado, $fechaEntregado);
    }

    //función que se encargará de ejecutar el proceso de cifrado e insertar el registo en la tabla documents.
    public function store(){
        $token = getallheaders();
        if($token["Authorization"] == 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MjMsIm5vbWJyZXMiOiJCZW5qYW1pbiIsInRlbGVmb25vIjoiOTgzMDAxOTA4MiIsImNvcnJlbyI6ImJlbjEwQGdtYWlsLmNvbSJ9.FMtm_O3EKkQkylL7Pc2INOHc7Tq_sA6Kq4Hv03mDFDM'){
            $this->generar_pdf($this->generar_qrcode($this->cifrar_datos($this->index())));
            //insertar el registro
            $this->cifrado();
            $actualizar_documents_id = new EventParticipantController();
            $actualizar_documents_id->update();
            echo json_encode("Documentos Generados");
            http_response_code(201);
        }else{
            http_response_code(401);
        }
    }


    public function decifrado($cadena, $iv){
        //Parametros que espera la funcion decifrar_cadena 
        $cadena_cifrada =  base64_decode(urldecode($cadena));
        $vector_inicializacion = base64_decode(urldecode($iv));

        $cadena_decifrada = $this->decifrar_cadena($cadena_cifrada, $vector_inicializacion);
        //$decifrar->documento();
        header('Content-Type: application/json');
        http_response_code(200);
        echo $cadena_decifrada;
   }

}




