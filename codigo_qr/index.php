<?php
//LIBRERIA PARA GENERAR CÓDIGOS QR 
require 'phpqrcode/qrlib.php';
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
$contenido = 'https://warhammer40k.fandom.com/wiki/Warhammer_40k_Wiki';

//UTILIZAMOS LA LIBRERIA
QRcode::png($contenido, $filename, $level, $tamaño, $frameSize);

echo '<img src="'.$filename.'" />';
?>