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

    $id_proveedor =$_GET['id'];//TOMAMOS EL ID DE LA VENTA PREVIAMENTE CREADO

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
    $prov = substr(str_repeat(0, 5).$id_proveedor, - 6);
    $pdf->MultiCell(69,4,utf8_decode(date_format(new \DateTime($Fecha_hoy.' '.$Hora), "d/m/Y H:i" ).'             FOLIO: '.$prov),0,'C',0);
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
    $proveedor = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `proveedores` WHERE id = $id_proveedor"));
    $pdf->SetFont('Courier','B', 9);
    $pdf->MultiCell(69,3,utf8_decode('NOMBRE: '.$proveedor['nombre']."\n".'CORREO:  '.$proveedor['correo']."\n".'DIRECCION: '.$proveedor['direccion']),0,'L',0);
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
    $pdf->SetY($pdf->GetY()-6);
    $pdf->SetX(36);
    $pdf->MultiCell(22,3,utf8_decode('EN ESPECIE (VALES)'),0,'L',0);           
    $pdf->SetY($pdf->GetY()-3);
    $pdf->SetX(58);
    $pdf->MultiCell(17,3,utf8_decode('$'.sprintf('%.2f',$proveedor['cuenta'])),0,'L',0);
    $pdf->SetY($pdf->GetY()+2);
    $pdf->SetX(6);
    $pdf->SetFont('Helvetica','', 8);
    $pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);
    $pdf->SetY($pdf->GetY()+1);
    $pdf->SetX(6);
    $pdf->SetFont('Helvetica','B', 10);
    $pdf->MultiCell(27,5,utf8_decode('Cuenta:'),0,'R',0);
    $pdf->SetY($pdf->GetY()-5);
    $pdf->SetX(35);
    $pdf->MultiCell(39,5,utf8_decode('$'.sprintf('%.2f',$proveedor['cuenta'])),0,'R',0);

    $pdf->SetY($pdf->GetY()+4);
    $pdf->SetX(6);
    $pdf->SetFont('Helvetica','', 8);
    
    $pdf->MultiCell(69,3,utf8_decode('NOTA: LAS CUENTAS NEGATIVAS SON DE PROVEEDORES QUE DARAN MERCANCIA POR VALES, HASTA QUEDAR EN 0 Y LAS CUENTAS EN POSITIVO, ES EFECTIVO QUE PRO-PUESTA 2023 PASARA A PAGAR DESPUES'),0,'L',0);
    $pdf->SetY($pdf->GetY()+1);
    $pdf->SetX(6);
    $pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);
    #$pdf->SetY($pdf->GetY());
    #$pdf->SetX(6);
   # $pdf->SetFont('Helvetica','B', 9);      
    #$id_user = $ventaAll['usuario'];// ID DEL USUARIO AL QUE SE LE APLICO EL CORTE
    #TOMAMOS LA INFORMACION DEL USUARIO QUE ESTA LOGEADO QUIEN HIZO LOS COBROS
    #$usuario = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE user_id = $id_user"));  
    #$pdf->MultiCell(69,4,utf8_decode('LE ATENDIO: '.$usuario['firstname'].' '.$usuario['lastname']),0,'C',0);
    #$pdf->SetY($pdf->GetY());
    #$pdf->SetX(6);
    #$pdf->SetFont('Helvetica','', 8);
    #$pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);

    $pdf->SetY($pdf->GetY()+3);
    $pdf->SetX(6);    
    $pdf->SetFont('Helvetica','B', 9);      
    $pdf->MultiCell(69,4,utf8_decode('¡GRACIAS POR TU APORTACION!'."\n".'PRO-PUESTA 2023 LO USARA PARA UN BIEN MAYOR'),0,'C',0);
    $pdf->SetY($pdf->GetY()+3);
    $pdf->SetFont('Helvetica','', 8);
    $pdf->SetX(6);
    $pdf->MultiCell(69,3,utf8_decode('-----------------------------------------------------------------------'),0,'L',0);


    $pdf->Output('COMPROBANTE','I');
    $doc = $pdf->Output('COMPROBANTE','S');

    $Aviso = 'Buen dia, le adjuntamos su comprobante por su aportacion GRACIAS!';
      #AVISO
      if ($Aviso != '') {
          $correo = new PHPMailer(true);
          try{
              #$correo->SMTPDebug = SMTP::DEBUG_SERVER;
              $correo->isSMTP();
              $correo->Host = 'sicsom.com';
              $correo->SMTPAuth = true;
              $correo->Username = 'cortes@sicsom.com';
              $correo->Password = '3.NiOYNE(Txj';
              $correo->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
              $correo->Port = 465;
              #COLOCAMOS UN TITULO AL CORREO  COMO REMITENTE
              $correo->setFrom('pro-puesta2023@hotmail.com', 'PRO-PUESTA 2023');
              #DEFINIMOS A QUE CORREOS SERAN LOS DESTINATARIOS
              $correo->addAddress($proveedor['correo'], $proveedor['nombre']);   
              $correo->Subject = 'Comprobante PRO-PUESTA 2023';// SE CREA EL ASUNTO DEL CORREO
              $correo->Body = $Aviso;
              $correo->AddStringAttachment($doc, 'comprobante.pdf', 'base64', 'application/pdf');
              $correo->send();
              echo "CORREO ENVIADO CON EXITO !!!";
          }catch(Exception $e){
              echo 'ERROR: '.$correo->ErrorInfo;
          }
    }
?>