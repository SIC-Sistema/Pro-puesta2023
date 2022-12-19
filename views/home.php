<!DOCTYPE html>
<html lang="en">
<head>
<?php
  include('nav.php');
  $datos = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `recaudaciones` LIMIT 1"));
?>
<title>SIC | Inicio</title>
</head>
<main>
<body>
	<div class="row container" name="Recaudado-1">
		<a name="Recaudado-1"></a>
		<div class="row center"><br><br>
			<img align="center" src="../img/LogoSIC.png">
			<br><h4 class="red-text text-darken-1">RECAUDACIONES TOTALES</h4><br><br>
			<div class="col s6 rigth">
				<h1 class="green-text courier"><b>$<?php echo sprintf('%.2f', $datos['efectivo']); ?></b></h1>
				<h6>En Efectivo</h6>
			</div>
			<div class="col s6 left">
				<h1 class="green-text"><b>$<?php echo sprintf('%.2f', $datos['vales']); ?></b></h1>
				<h6>En Vales</h6>
			</div>
		</div>  

	</div>
 	<div class="row container" name="Conocenos-2"><br><br><br><br><br>
 		<a name="Conocenos-2"></a>
 		<div class="row center">
			<img align="center" src="../img/convocatoria.jpg">
 		</div>
 	</div>
 	<div class="row container" name="Contacto-3"><br><br><br><br>
 		<a name="Contacto-3"></a>
 		<div class="row center">
			<img align="center" src="../img/Contacto.jpg">
 		</div>
 	</div><br><br><br>



	<div class="fixed-action-btn">
	  <a href="new_asociado.php" class="waves-effect waves-light btn-large orange"><i class="material-icons left">mood</i>Quiero Ser Asociado <i class="material-icons right">add</i></a>
	</div>


</body>
</main>
</html>