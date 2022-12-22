<?php
#INCLUIMOS TODAS LAS LIBRERIAS  DE MAILER PARA PODER ENVIAR CORREOS DE ESTE ARCHIVO
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/vendor/autoload.php';
#INCLUIMOS EL ARCHIVO CON LA CONEXION A LA BASE DE DATPS
    include('../php/conexion.php');
    #INCLUIMOS EL ARCHIVO CON LAS LIBRERIAS DE FPDF PARA PODER CREAR ARCHIVOS CON FORMATO PDF
    include("../fpdf/fpdf.php");
    include('is_logged.php');
    $id =$_GET['id'];//TOMAMOS EL ID DE LA VENTA PREVIAMENTE CREADO
    //LIBRERIA PARA GENERAR CÓDIGOS QR 
    require '../codigo-qr/phpqrcode/qrlib.php';
    //CARPETA PARA GUARDAR LOS CÓDIGOS QR GENERADOS
    $dir = '../temp/';
    //SI LA CARPETA PARA GUARDAR LOS COÓDIGOS QR NO EXISTE, SE CREA
    if(!file_exists($dir)){
        mkdir($dir);
    }
    //NOMBRE DEL ARCHIVO QR
    $filename = $dir.'test.png';

    //PARAMENTROS DEL CÓDIGO QR
    $tamaño = 5;
    $level = 'H';
    $frameSize = 3;
    $contenido = 'https://sicsom.com/Pro-puesta2023/views/canjear.php?folio='.$id;

    //UTILIZAMOS LA LIBRERIA
    QRcode::png($contenido, $filename, $level, $tamaño, $frameSize);
    #DEFINIMOS UNA ZONA HORARIA
    date_default_timezone_set('America/Mexico_City');
    $Fecha_hoy = date('Y-m-d');//CREAMOS UNA FECHA DEL DIA EN CURSO SEGUN LA ZONA HORARIA
    $Hora = date('H:i:s');
   
class PDF extends FPDF{

    }

    $pdf = new PDF('P', 'mm', array(80,297));
    $pdf->setTitle(utf8_decode('Pro-puesta | TICKET COMPROBANTE'));// TITULO BARRA NAVEGACION
    $pdf->AddPage();

    $pdf->Image('../img/logo_ticket.jpg', 30, 6, 20, 21, 'jpg'); /// LOGO SIC

    /// INFORMACION DE LA EMPRESA ////
    $pdf->SetFont('Courier','B', 8);
    $pdf->SetY($pdf->GetY()+19);
    $pdf->SetX(6);
    $pdf->MultiCell(69,3,utf8_decode('¡Uniendo Sombrerete!'."\n".'TEL. 4331113868'),0,'C',0);
    /// INFORMACION DE LA VENTA
    $pdf->SetY($pdf->GetY()+4);
    $pdf->SetX(6);
    $pdf->SetFont('Helvetica','B', 10);    
    $folio = substr(str_repeat(0, 5).$id, - 6);
    $pdf->MultiCell(69,4,utf8_decode(date_format(new \DateTime($Fecha_hoy.' '.$Hora), "d/m/Y H:i" ).'             FOLIO: '.$folio),0,'C',0);
    $pdf->SetY($pdf->GetY()+1);
    $pdf->SetX(6);
    $pdf->SetFont('Helvetica','', 8);
    $pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);
    $pdf->SetY($pdf->GetY());
    $pdf->SetX(6);
    $pdf->SetFont('Helvetica','B', 11);
    $pdf->MultiCell(69,4,utf8_decode('TICKET COMPROBANTE'),0,'C',0);
    $pdf->SetY($pdf->GetY());
    $pdf->SetX(6);
    $pdf->Image($filename, 30, 6, 20, 21, 'png'); /// LOGO SIC

    $pdf->SetFont('Helvetica','', 8);
    $pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);   
    
    $pdf->SetY($pdf->GetY()+3);
    $pdf->SetX(6);    
    $pdf->SetFont('Helvetica','B', 9);      
    $pdf->MultiCell(69,4,utf8_decode('¡GRACIAS POR TU APORTACION!'."\n".'PRO-PUESTA 2023 LO USARA PARA UN BIEN MAYOR'),0,'C',0);
    $pdf->SetY($pdf->GetY()+3);
    $pdf->SetFont('Helvetica','', 8);
    $pdf->SetX(6);
    $pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);


    $pdf->Output('COMPROBANTE','I');
?>