<?php

require_once('./Core/conexion.php');
require_once('./Modulos/Modelo/Document.php');
require_once('./Modulos/Modelo/Participant.php');
require_once('./qrcode/phpqrcode/qrlib.php');
require_once('./Core/DBAbstractLayer.php');
require_once('./fpdf/fpdf.php');


class DocumentoController{


    public function index(){
        $participants = new Participant();
        $participantes = $participants->get_participants();

        $participante = array();
        foreach($participantes as $participant){
            $participante = $participant;
        } 

        $datos = array(
            "nombre" => $participante['Nombres'],
            "Apellido Paterno" => $participante['Apellido_Paterno'],
            "Apellido Materno" => $participante['Apellido_Materno'],
            "Evento" => $participante['Evento'],
            "Tipo Participante" => $participante['Tipo_Participante'],
            "Fecha Inicio" => $participante['fechaInicio'],
            "Fecha Termino" => $participante['fechaTermino'], 
            "Instituto" => $participante['Instituto'], 
        );
        $this->cifrar_datos($datos);
        return $participantes;
    }


    public function cifrar_datos($datos){
        $jsonencript = json_encode($datos);
        //Key cifrado
        $passphrase = 'ThePassword';
        $cipherMethods = openssl_get_cipher_methods();
        //Método de cifrado a usar
        $cipherMethod = $cipherMethods[45];

        //Generacion del iv
        try {
            //obtiene la longitud del cifrado iv
            $inicializationVectorLength = openssl_cipher_iv_length($cipherMethod);
        } catch (Exception $e) {
            echo 'ERROR getting IV length, using 256' . PHP_EOL;
            $inicializationVectorLength = 256;
        }
        //genera una cadena pseudoaleatoria de bytes
        $inicializationVector = openssl_random_pseudo_bytes($inicializationVectorLength);
        $iv = base64_encode($inicializationVector);


        //crifrar datos
        $encryptedData = base64_encode(openssl_encrypt($jsonencript, $cipherMethod, $passphrase, OPENSSL_RAW_DATA, $inicializationVector));
        $url = 'http://localhost/api-documentos/controlador/DocumentController.php?cadena='. urlencode($encryptedData) . '&iv=' . urlencode($iv);
        return $url;

    }


    public function generar_qrcode($url){
        //nombre y ruta del png
        $nombre_png = uniqid().'.png';
        $ruta_png_QRcode = './Static/img'.'/'.$nombre_png;
        QRcode::png($url, $ruta_png_QRcode);
        $this->generar_pdf($ruta_png_QRcode);
        echo $url;
        return $ruta_png_QRcode;
    }

    public function generar_pdf($QRcode){
        //nombre y ruta del archivo pdf
        $nombre_pdf = 'Certificado de participacion Academia Journals.pdf';
        $ruta_pdf ='./Static/PDF/' . $nombre_pdf;
        //ruta del png
        $ruta_png = './Static/certificado/certificado.png';
        
       
        //crear pdf
        $pdf = new FPDF();
        $pdf->AddPage('horizontal');
        $pdf->Image($ruta_png, 0, 0, 300, 210,'PNG');
        $pdf->Image($QRcode,  0, 180, 30, 30,'PNG');
        // Guardar el archivo pdf en la carpeta especificada
        $pdf->Output('F', $ruta_pdf);
        
    }


    public function store($ruta_pdf){
        $documents = new Document();
        $numero = "1936451425";
        $generado = true;
        $entregado = true;
        $archivo = $ruta_pdf;
        $fechaGenerado = date('Y-m-d H:i:s');
        $fechaEntregado = date('Y-m-d H:i:s');
        //$documents->create($numero, $generado, $entregado, $archivo, $fechaGenerado, $fechaEntregado);

    }
}


require_once('./Modulos/Vista/view.php');



