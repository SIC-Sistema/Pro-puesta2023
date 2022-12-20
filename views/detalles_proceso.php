<!DOCTYPE html>
<html lang="en">
<head>
<?php
  include('nav.php');
?>
<title>SIC | Inicio</title>
</head>
<main>
<body >
	<?php
	if (isset($_GET['tipo']) == true) {
		$tipo = $_GET['tipo'];
		if ($tipo =='Efectivo') {
			?>
			<script>
				$(document).ready(function(){
				    $('#modalEfectivo').modal();
				    $('#modalEfectivo').modal('open'); 
				 });
			</script>
			<div id="modalEfectivo" class="modal">
			    <div class="modal-content row">
			      <h3 class="red-text center"><b>¡Nota!</b></h3><br>

			      <h6 class="blue-text"><b>1.- Pasar a dejar el efectivo a la direccion Av. XXXXXX.</b></h6>
			      <h6 class="blue-text"><b>2.- O transferir a la cuenta 000000000 y enviar el comprobante al Whatsapp 000000.</b></h6>
			      <h6 class="blue-text"><b>3.- Una vez confirmado su aportación se le entregara o se le enviara via Whatsapp un ticket como comprobante.</b></h6>		
			      <h6 class="blue-text"><b>3.- Una vez confirmado su aportación y enviado el comprobante la cantidad total se vera reflejada rn la pagina sumandose al total recaudado.</b></h6>			      
			      
			      <a href="home.php" class="modal-action modal-close waves-effect waves-green btn-large green right">Aceptar<i class="material-icons left">done</i></a>
			    </div>
			</div>
		<?php
		}// FIN IF EFECTIVO
	}//FIN IF ISSET
	?>
</body>
</main>
</html>