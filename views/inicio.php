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
	<header>
		<div class="content-header">
			<div class="logo"><img src="../img/Logo_propuesta.png"></div>
			<div class="item"><a href="#somos">¿Quienes somos?</a></div>
			<div class="item"><a href="#asociado">¡Quiero ser asociado!</a></div>
			<div class="item"><a href="#recaudacion">Recaudado</a></div>
			<div class="item"><a href="#contacto">Contactanos</a></div>
		</div>
	</header>
    <!-- BANNER -->
	<div class="contents">
		<section id="somos">
            <div class="content-banner">
                <div class="banner-text">
                    <h1>UNIENDO SOMBRERETE</h1>
                    <h2>RECAUDACIONES</h2>
                    <table>
                        <tr>
                            <td>En Efectivo</td>
                            <td>En vales</td>
                        </tr>
                        <tr>
                            <td>$10000</td>
                            <td>$1200</td>
                        </tr>
                    </table>

                </div>
                <div class="banner-img">
                    <img src="../img/Logo_propuesta.png">
                </div>
            </div>
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
		</section>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 300">
	  	<path fill="#ffffff" fill-opacity="1" d="M0,32L34.3,42.7C68.6,53,137,75,206,117.3C274.3,160,343,224,411,224C480,224,549,160,617,160C685.7,160,754,224,823,218.7C891.4,213,960,139,1029,128C1097.1,117,1166,171,1234,202.7C1302.9,235,1371,245,1406,250.7L1440,256L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
	    </svg>
		<section id="productos">
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