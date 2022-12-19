<?php
#INCLUIMOS EL ARCHIVO CON LOS DATOS Y CONEXXION A LA BASE DE DATOS
include('../php/conexion.php');
#GENERAMOS UNA FECHA DEL DIA EN CURSO REFERENTE A LA ZONA HORARIA
$Hoy = date('Y-m-d');
?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!--Import material-icons.css-->
      <link href="css/material-icons.css" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	  <link rel="shortcut icon" href="../img/logo_ticket.jpg" type="image/jpg" />
      <style rel="stylesheet">
		.dropdown-content{  overflow: visible;	}
	  </style>
	<div class="navbar-fixed">
	<nav class="indigo lighten-5">
		<div class="nav-wrapper container">
			<a  class="brand-logo" href="home.php"><img  class="responsive-img" style="width: 60px; height: 58px;" src="../img/LogoSIC.png"></a>
			<!-- CREAMOS UN DIV EL CUAL TENGA id = "resultado_venta"  PARA QUE EN ESTA PARTE NOS MUESTRE LOS RESULTADOS EN TEXTO HTML DEL SCRIPT EN FUNCION  -->
        	<div  id="resultado_venta"></div>
			<a href="#" data-target="menu-responsive" class="sidenav-trigger">
				<i class="material-icons">menu</i>
			</a>
			<ul class="right hide-on-med-and-down">
				<li><a class='dropdown-button red-text' href="home.php#Recaudado-1"><i class="material-icons left">monetization_on</i><b>Recaudado</b> </a></li>
				
				<li><a class='dropdown-button amber-text' href="home.php#Conocenos-2"><i class="material-icons left">accessibility</i><b>Conocenos</b></a></li>
				
 				<li><a class='dropdown-button green-text' href="home.php#Contacto-3"><i class="material-icons left">account_box</i><b>Contacto</b> </a></li> 				
 				<li><a class='dropdown-button grey-text text-darken-3' href="new_asociado.php"><i class="material-icons left">add</i><b>Asociados</b> </a></li> 		
			</ul>			
		</div>		
	</nav>
	</div>
	<!-- BARRA DE NAVEGACION DE LA IZQUIERDA MOBILES Y TABLETAS --->
	<ul class="sidenav indigo lighten-5" id="menu-responsive" style="width: 270px;">
		<h2>Menú</h2>
    	<li><div class="divider"></div></li><br>

		<li><a class='dropdown-button indigo-text' href="home.php#Recaudado-1"><i class="material-icons left">monetization_on</i><b>Recaudado</b> </a></li>
				
		<li><a class='dropdown-button indigo-text' href="home.php#Conocenos-2"><i class="material-icons left">accessibility</i><b>Conocenos</b></a></li>

		<li><a class='dropdown-button indigo-text' href="home.php#Contacto-3"><i class="material-icons left">account_box</i><b>Contacto</b> </a></li> 	

 		<li><a class='dropdown-button indigo-text' href="new_asociado.php"><i class="material-icons left">add</i><b>Asociados</b> </a></li> 				
	</ul>
	<?php 
	include('../views/modals.php');
	?>
	<script src="js/jquery-3.1.1.js"></script>
	<!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
	<script>
		function nueva_venta(){
			//SI LOS IF NO SE CUMPLEN QUIERE DECIR QUE LA INFORMACION CUENTA CON TODO LO REQUERIDO
	        //MEDIANTE EL METODO POST ENVIAMOS UN ARRAY CON LA INFORMACION AL ARCHIVO EN LA DIRECCION "../views/dos_ventas.php"
	        $.post("dos_ventas.php", {
	          //Cada valor se separa por una ,
	          }, function(mensaje) {
	            //SE CREA UNA VARIABLE LA CUAL TRAERA EN TEXTO HTML LOS RESULTADOS QUE ARROJE EL ARCHIVO AL CUAL SE LE ENVIO LA INFORMACION "dos_ventas.php"
	            $("#resultado_venta").html(mensaje);
	        });
		}
		function nueva_factura(id_venta){
			//SI LOS IF NO SE CUMPLEN QUIERE DECIR QUE LA INFORMACION CUENTA CON TODO LO REQUERIDO
	        //MEDIANTE EL METODO POST ENVIAMOS UN ARRAY CON LA INFORMACION AL ARCHIVO EN LA DIRECCION "../php/control_facturas.php"
	        $.post("../php/control_facturas.php", {
	          //Cada valor se separa por una ,
	        	accion: 0,
	        	venta: id_venta,
	        	nueva: 0,
	          }, function(mensaje) {
	            //SE CREA UNA VARIABLE LA CUAL TRAERA EN TEXTO HTML LOS RESULTADOS QUE ARROJE EL ARCHIVO AL CUAL SE LE ENVIO LA INFORMACION "control_facturas.php"
	            $("#resultado_venta").html(mensaje);
	        });
		}
    	$(document).ready(function() {	    
	 	$('.dropdown-button').dropdown({
	      	  inDuration: 500,
	          outDuration: 500, 
	          constrainWidth: false, // Does not change width of dropdown to that of the activator
	          coverTrigger: false, 
	    });
	    $('.dropdown-btn').dropdown({
	      	  inDuration: 500,
	          outDuration: 500,
	          hover: true,
	          constrainWidth: true, // Does not change width of dropdown to that of the activator
	          coverTrigger: false, 
	    });
	    $('.dropdown-btn1').dropdown({
	      	  inDuration: 500,
	          outDuration: 500,
	          alignment: 'left',
	          hover: true,
	          constrainWidth: true, // Does not change width of dropdown to that of the activator
	          coverTrigger: false, 
	    });
	    $('tooltipped').tooltip();
	    });
		document.addEventListener('DOMContentLoaded', function(){
			M.AutoInit();
		});
		document.addEventListener('DOMContentLoaded', function() {
		    var elems = document.querySelectorAll('.fixed-action-btn');
		    var instances = M.FloatingActionButton.init(elems, {
		      direction: 'left'
		    });
		});
		$('.dropdown-button2').dropdown({
		      inDuration: 300,
		      outDuration: 225,
		      constrain_width: false, // Does not change width of dropdown to that of the activator
		      hover: true, // Activate on hover
		      gutter: ($('.dropdown-content').width()*3)/2.5 + 5, // Spacing from edge
		      belowOrigin: false, // Displays dropdown below the button
		      alignment: 'left' // Displays dropdown with edge aligned to the left of button
		    }
		);
		$('.button-collapse').sideNav({
		      menuWidth: 347, 
		      edge: 'left',
		      closeOnClick: false,
		      draggable: true 
		    }
		  );

		$('.modal').modal();

		$(document).ready(function(){
    		$('.slider').slider();
		});
		$(document).ready(function(){
		  $('.materialboxed').materialbox();
		});  

	    var toastElement = document.querySelector('.toast');
	    var toastInstance = M.Toast.getInstance(toastElement);
	    toastInstance.dismiss(); 
  
		M.AutoInit();
        var options={
        };
        document.addEventListener('DOMContentLoaded', function () {
            var elems = document.querySelectorAll('.carousel');
            var instances = M.Carousel.init(elems, options);
        });
	</script>