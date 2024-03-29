<?php
#INCLUIMOS EL PHP DONDE VIENE LA INFORMACION DEL INICIO DE SESSION
include('../php/is_logged.php');
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
	  <link rel="shortcut icon" href="../img/logo.jpg" type="image/jpg" />
      <style rel="stylesheet">
		.dropdown-content{  overflow: visible;	}
	  </style>
	<div class="navbar-fixed">
	<nav class="indigo lighten-5">
		<div class="nav-wrapper container">
			<a  class="brand-logo" href="home.php"><img  class="responsive-img" style="width: 60px; height: 58px;" src="../img/Logo.png"></a>
			<!-- CREAMOS UN DIV EL CUAL TENGA id = "resultado_venta"  PARA QUE EN ESTA PARTE NOS MUESTRE LOS RESULTADOS EN TEXTO HTML DEL SCRIPT EN FUNCION  -->
        	<div  id="resultado_venta"></div>
			<a href="#" data-target="menu-responsive" class="sidenav-trigger">
				<i class="material-icons">menu</i>
			</a>
			<ul class="right hide-on-med-and-down">
				<li><a class='light-blue-text text-darken-3' href="asociados.php"><i class="material-icons left">person</i><b>Asociados</b></a></li>
				
				<li><a class='dropdown-button light-blue-text text-darken-3' data-target='dropdown2'><i class="material-icons left">local_grocery_store</i><b>Proveedores</b><i class="material-icons right">arrow_drop_down</i></a></li>
				<ul id='dropdown2' class='dropdown-content'>
					<li><a href = "new_proveedor.php" class="light-blue-text text-darken-3"><i class="material-icons">add</i>Nuevo Proveedor</a></li>
					<li><a href = "list_proveedores.php" class="light-blue-text text-darken-3"><i class="material-icons">list</i>Lista Proveedores</a></li>
 				</ul>
 				<li><a class='dropdown-button light-blue-text text-darken-3' data-target='dropdown5'><i class="material-icons left">accessibility</i><b>Beneficiados</b> <i class="material-icons right">arrow_drop_down</i></a></li>
				<ul id='dropdown5' class='dropdown-content'>   
					<li><a href="new_beneficiario.php" class="light-blue-text text-darken-3"><i class="material-icons">group_add</i>Nuevo Beneficio</a></li>   
				</ul>
 				<li><a class='dropdown-button light-blue-text text-darken-3' data-target='dropdown4'><b><?php echo $_SESSION['user_name'];?> </b><i class="material-icons right">arrow_drop_down</i></a></li>
				<ul id='dropdown4' class='dropdown-content'>
				    <li><a href="../php/cerrar_sesion.php" class="light-blue-text text-darken-3"><i class="material-icons">exit_to_app</i>Cerrar Sesión</a></li>
 				 </ul>
			</ul>
			<ul class="right hide-on-large-only hide-on-small-only">
				<li><a class='dropdown-button light-blue-text text-darken-3' data-target='dropdown10'><b><?php echo $_SESSION['user_name'];?> </b><i class="material-icons right">arrow_drop_down</i></a></li>
				<ul id='dropdown10' class='dropdown-content'>
				    <li><a href="../php/cerrar_sesion.php" class="light-blue-text text-darken-3"><i class="material-icons">exit_to_app</i>Cerrar Sesión</a></li>
 				 </ul>
			</ul>
			<ul class="right hide-on-med-and-up">
		        <li><a class='dropdown-button light-blue-text text-darken-3' data-target='dropdown8'><i class="material-icons left">account_circle</i><b>></b></a></li>
				<ul id='dropdown8' class='dropdown-content'>
				   <li><a href="../php/cerrar_sesion.php" class="light-blue-text text-darken-3"><i class="material-icons">exit_to_app</i>Cerrar Sesión</a></li>
 				</ul>
		    </ul>			
		</div>		
	</nav>
	</div>
	<!-- BARRA DE NAVEGACION DE LA IZQUIERDA MOBILES Y TABLETAS --->
	<ul class="sidenav indigo lighten-5" id="menu-responsive" style="width: 270px;">
		<h2>Menú</h2>
    	<li><div class="divider"></div></li><br>
		
	    <li><a href="asociados.php"><i class="material-icons left">person</i><b>Asociados</b></a></li>    			
	    
		<li>
	    	<ul class="collapsible collapsible-accordion">
	    		<li>
	    			<div class="collapsible-header"><i class="material-icons">local_grocery_store</i>Proveedores <i class="material-icons right">arrow_drop_down</i></div>
		      		<div class="collapsible-body indigo lighten-5">
		      			<span>
		      			  <ul>
							<li><a href = "new_proveedor.php"><i class="material-icons">add</i>Nuevo Proveedor</a></li>
							<li><a href = "list_proveedores.php"><i class="material-icons">list</i>Lista Proveedores</a></li>
					      </ul>
					    </span>
		      		</div>    			
	    		</li>	    			
	    	</ul>	     				
	    </li>
		<li>
	    	<ul class="collapsible collapsible-accordion">
	    		<li>
	    			<div class="collapsible-header"><i class="material-icons">accessibility</i>Beneficiados <i class="material-icons right">arrow_drop_down</i></div>
		      		<div class="collapsible-body  indigo lighten-5">
		      			<span>
		      			  <ul>		     				
							<li><a href="new_beneficiario.php"><i class="material-icons">group_add</i>Nuevo Beneficio</a></li>   
					      </ul>
					    </span>
		      		</div>    			
	    		</li>	    			
	    	</ul>	     				
	    </li>
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