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
    $pdf->SetFont('Helvetica','', 8);
    $pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);   
    
    $pdf->SetY($pdf->GetY());
    $pdf->SetX(6);
    $asociado = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `asociados` WHERE id = $id"));
    $pdf->SetFont('Courier','B', 9);
    $pdf->MultiCell(69,3,utf8_decode('N° ASOCIADO: '.$asociado['id']."\n".'NOMBRE: '.$asociado['nombre']."\n".'TELEFONO:  '.$asociado['telefono']),0,'L',0);
    $pdf->SetY($pdf->GetY());
    $pdf->SetX(6);    
    $pdf->SetFont('Helvetica','', 8);
    $pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);
    $pdf->SetY($pdf->GetY());
    $pdf->SetX(6);
    $pdf->SetFont('Helvetica','B', 8);    
    $pdf->MultiCell(69,4,utf8_decode('  DESCRIPCION             TIPO                  TOTAL'),0,'L',0);
    $pdf->SetY($pdf->GetY());
    $pdf->SetX(6);
    $pdf->SetFont('Helvetica','', 8);
    $pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);
    
    $pdf->SetY($pdf->GetY()+1);
    $pdf->SetX(6);
    $pdf->MultiCell(30,3,utf8_decode('APORTACION VOLUNTARIA PARA PRO-PUESTA 2023'),0,'L',0);
    $pdf->SetY($pdf->GetY()-3);
    $pdf->SetX(36);
    $pdf->MultiCell(22,3,utf8_decode('EN EFECTIVO'),0,'L',0);           
    $pdf->SetY($pdf->GetY()-3);
    $pdf->SetX(58);
    $pdf->MultiCell(17,3,utf8_decode('$'.sprintf('%.2f',$asociado['cantidad'])),0,'L',0);
    $pdf->SetY($pdf->GetY()+2);
    $pdf->SetX(6);
    $pdf->SetFont('Helvetica','', 8);
    $pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);
    $pdf->SetY($pdf->GetY()+1);
    $pdf->SetX(6);
    $pdf->SetFont('Helvetica','B', 10);
    $pdf->MultiCell(27,5,utf8_decode('EFECTIVO:'),0,'R',0);
    $pdf->SetY($pdf->GetY()-5);
    $pdf->SetX(35);
    $pdf->MultiCell(39,5,utf8_decode('$'.sprintf('%.2f',$asociado['cantidad'])),0,'R',0);

    $pdf->SetY($pdf->GetY()+4);
    $pdf->SetX(6);
    $pdf->SetFont('Helvetica','', 8);

    $pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);
    $pdf->SetY($pdf->GetY());
    $pdf->SetX(6);
    $pdf->SetFont('Helvetica','B', 9);      
    $id_user = $_SESSION['user_id'];// ID DEL USUARIO LOGEADO
    #TOMAMOS LA INFORMACION DEL USUARIO QUE ESTA LOGEADO QUIEN HIZO LOS COBROS
    $usuario = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE user_id = $id_user"));  
    $pdf->MultiCell(69,4,utf8_decode('LE ATENDIO: '.$usuario['firstname'].' '.$usuario['lastname']),0,'C',0);
    $pdf->SetY($pdf->GetY());
    $pdf->SetX(6);
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