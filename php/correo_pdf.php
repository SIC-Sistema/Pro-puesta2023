<?php
#Falla
#INCLUIMOS EL ARCHIVO CON LA CONEXION A LA BASE DE DATOS
include('../php/conexion.php');
#INCLUIMOS TODAS LAS LIBRERIAS  DE MAILER PARA PODER ENVIAR CORREOS DE ESTE ARCHIVO
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/vendor/autoload.php';

#INCLUIMOS EL ARCHIVO CON LA CONEXION A LA BASE DE DATPS
    include('../php/conexion.php');
    #INCLUIMOS EL ARCHIVO CON LAS LIBRERIAS DE FPDF PARA PODER CREAR ARCHIVOS CON FORMATO PDF
    include("../fpdf/fpdf.php");

    
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
    $pdf->MultiCell(69,4,utf8_decode(date_format(new \DateTime($Fecha_hoy.' '.$Hora), "d/m/Y H:i" ).'             FOLIO: 0000'),0,'C',0);
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
    $pdf->SetFont('Helvetica','', 8);
    $pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);   
    
    
    $pdf->SetY($pdf->GetY());
    $pdf->SetX(6);
    
    $pdf->MultiCell(69,3,utf8_decode('NOTA: LAS CUENTAS NEGATIVAS SON DE PROVEEDORES QUE DARAN MERCANCIA POR VALES, HASTA QUEDAR EN 0 Y LAS CUENTAS EN POSITIVO, ES EFECTIVO QUE PRO-PUESTA 2023 PASARA A PAGAR DESPUES'),0,'L',0);
    $pdf->SetY($pdf->GetY()+1);
    $pdf->SetX(6);
    $pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);
   
    $pdf->SetY($pdf->GetY()+3);
    $pdf->SetX(6);    
    $pdf->SetFont('Helvetica','B', 9);      
    $pdf->MultiCell(69,4,utf8_decode('¡GRACIAS POR TU APORTACION!'."\n".'PRO-PUESTA 2023 LO USARA PARA UN BIEN MAYOR'),0,'C',0);
    $pdf->SetY($pdf->GetY()+3);
    $pdf->SetFont('Helvetica','', 8);
    $pdf->SetX(6);
    $pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);


    $pdf->Output('COMPROBANTE','S');
    $doc = $pdf->Output('COMPROBANTE','S');

    $Aviso = 'Buen dia, le adjuntamos su comprobante por su aportación ¡GRACIAS!';
      #AVISO
      if ($Aviso != '') {
          $correo = new PHPMailer(true);
          try{
              #$correo->SMTPDebug = SMTP::DEBUG_SERVER;
              $correo->isSMTP();
              $correo->Host = 'mail.hotmail.com';
              $correo->SMTPAuth = true;
              $correo->Username = 'pro-puesta2023@hotmail.com';
              $correo->Password = 'Pro-puesta20';
              $correo->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
              $correo->Port = 465;
              #COLOCAMOS UN TITULO AL CORREO  COMO REMITENTE
              $correo->setFrom('pro-puesta2023@hotmail.com', 'PRO-PUESTA 2023');
              #DEFINIMOS A QUE CORREOS SERAN LOS DESTINATARIOS
              $correo->addAddress('alfredo.martinez@sicsom.com', 'Fredo');
              $correo->addAddress('alfredomartinez6510@gmail.com', 'Fredo2');
   
              $correo->Subject = 'COMPROBANTE';// SE CREA EL ASUNTO DEL CORREO
              $correo->Body = $Aviso;
              $correo->AddStringAttachment($doc, 'doc.pdf', 'base64', 'application/pdf');
              $correo->send();
              echo "CORREO ENVIADO CON EXITO !!!";
          }catch(Exception $e){
              echo 'ERROR: '.$correo->ErrorInfo;
          }
    }
