<?php
//LIBRERIA PARA GENERAR CÓDIGOS QR 
require 'phpqrcode/qrlib.php';
//CARPETA PARA GUARDAR LOS CÓDIGOS QR GENERADOS
$dir = 'temp/';
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
$contenido = 'https://sicsom.com/Pro-puesta2023/views/admin.php';

//UTILIZAMOS LA LIBRERIA
QRcode::png($contenido, $filename, $level, $tamaño, $frameSize);

echo '<img src="'.$filename.'" />';
?>