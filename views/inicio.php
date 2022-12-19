<!-- Incluimos el navbar -->
<?php
include('nav.php'); 
$efectivo = mysqli_fetch_array(mysqli_query($conn, "SELECT efectivo FROM `recaudaciones` WHERE id_recaudacion = 1"));
$vales = mysqli_fetch_array(mysqli_query($conn, "SELECT vales FROM `recaudaciones` WHERE id_recaudacion = 2"));

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Uniendo Sombrerete</title>
    <!-- icono de la pestaña -->
	<link rel="icon" type="image/png" href="../img/LogoSIC.png">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <!-- BANNER -->
	<div class="contents">
		<section id="somos" class="row">
            <div class="content-banner">
                <div class="banner-text">
                    <div class="banner-img">
                    <img src="../img/LogoSIC.png">
                </div>
                <h1>RECAUDACIONES TOTALES</h1>
            
                
            </div>
			
		</section><br><br><br><br><br><br>
		<section id="productos" class="row"><br><br><br><br>
			<h1>Nuestros inicios</h1>
			<div class="div-flex">
				<div class="parts">
					<div class="content-img">
						<div class="img"></div>
					</div>
				</div>
				<div class="parts">
					<h2>De panadería a pastelería</h2>
					<p>Comenzamos siendo una panaderia hace mas de 30 años. Todo el trabajo siempre habia sido artesanal y se pasaron los secretos de padre a hijo.</p>
					<p>Gracias a los nuevos talentos de hoy en dia, pudimos ampliar nuestros productos para agregar deliciosos bocadillos dulces y salados a nuestra produccion.</p>
				</div>
			</div>
			<h1>Productos más pedidos</h1>
			<div class="div-grid">
				<div class="grid-item">
					<div class="content-img-pro">
						<img src="assets/img/torta.jpg">
					</div>
					<h3>Tortas</h3>
					<p>De todos los rellenos y de la forma que mas te guste</p>
				</div>
				<div class="grid-item">
					<div class="content-img-pro">
						<img src="assets/img/biscochuelo.jpg">
					</div>
					<h3>Biscochuelos</h3>
					<p>Ideales para toda ocacision</p>
				</div>
				<div class="grid-item">
					<div class="content-img-pro">
						<img src="assets/img/bocaditos.jpg">
					</div>
					<h3>Bocaditos</h3>
					<p>Ideales para toda ocacision</p>
				</div>
				<div class="grid-item">
					<div class="content-img-pro">
						<img src="assets/img/panes.jpg">
					</div>
					<h3>Panes</h3>
					<p>De todas las variedades y texturas</p>
				</div>
			</div>
		</section>
		<section id="servicios">
			<h1>Servicios que realizamos</h1>
			<div class="div-grid">
				<div class="grid-item">
					<div class="content-img-pro">
						<img src="assets/img/horneado.jpg">
					</div>
					<h3>Horneado</h3>
					<p>Si tienes algun carne que quisieras hornear, nosotros te ayudamos con ello</p>
				</div>
				<div class="grid-item">
					<div class="content-img-pro">
						<img src="assets/img/compra-online.jpg">
					</div>
					<h3>Compra en linea</h3>
					<p>Por nuestro canales de venta digitales, puedes comprar sin salir de casa</p>
				</div>
				<div class="grid-item">
					<div class="content-img-pro">
						<img src="assets/img/delivery.jpg">
					</div>
					<h3>Delivery</h3>
					<p>Tus compras llegaran a la ti sin necesidad de salir de casa</p>
				</div>
			</div>
		</section>
		<section id="contacto">
			<h1>Comunicate con nosotros</h1>
			<div class="div-flex">
				<div class="parts">
					<h2>Tienes pensado un evento o reunión?</h2>
					<p>Dejanos un mensaje con lo que necesitas saber para resolver cualquier duda que tengas</p>
					<h4>Correo: prueba@gmail.com</h4>
					<h4>Celulares: 999 888 777 / 999 555 333</h4>
				</div>
				<div class="parts">
					<h2 style="margin-bottom: 10px;">Envia tu consulta ahora!</h2>
					<form>
						<label>Nombre</label>
						<input type="text" id="nombre" placeholder="Nombre">
						<br>
						<label>DNI</label>
						<input type="number" id="dni" placeholder="DNI">
						<br>
						<label>Correo</label>
						<input type="text" id="correo" placeholder="Correo">
						<br>
						<label>Celular</label>
						<input type="number" id="celular" placeholder="Celular">
						<br>
						<label>Consulta</label>
						<textarea id="consulta"></textarea>
						<br>
						<button onclick="send_mensaje()">Enviar mensaje</button>
					</form>
				</div>
			</div>
		</section>
	</div>
	<footer>
		<center><p>Punto y Coma - Tutoriales | 2019</p></center>
	</footer>
	<script type="text/javascript">
		function send_mensaje(){
			if (document.getElementById("nombre").value=="" ||
				document.getElementById("dni").value=="" ||
				document.getElementById("correo").value==""||
				document.getElementById("celular").value==""||
				document.getElementById("consulta").value=="") {
				alert("Debe completar sus datos");
				return;
			}
			var fd=new FormData();
			fd.append('nombre',document.getElementById("nombre").value);
			fd.append('correo',document.getElementById("correo").value);
			fd.append('celular',document.getElementById("celular").value);
			fd.append('dni',document.getElementById("dni").value);
			fd.append('consulta',document.getElementById("consulta").value);
			var request=new XMLHttpRequest();
			request.open('POST','api/api_save_mensaje.php');
			request.onload=function (){
				console.log(request);
				if (request.readyState==4 && request.status==200) {
					if (request.responseText=="1") {
						alert("Se envió el mensaje correctamente");
					}else{
						alert("Hubo un error, intente más tarde");
					}
				}
			}
			request.send(fd);
		}
	</script>
</body>
</html>