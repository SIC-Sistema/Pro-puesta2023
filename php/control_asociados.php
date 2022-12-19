<?php 
// Si estamos usando una versión de PHP superior entonces usamos la API para encriptar la contrasela con el archivo: password_api_compatibility_library.php
include_once("password_compatibility_library.php");
//ARCHIVO QUE CONTIENE LA VARIABLE CON LA CONEXION A LA BASE DE DATOS
include('../php/conexion.php');

//DEFINIMOS LA ZONA  HORARIA
date_default_timezone_set('America/Mexico_City');
$Fecha_hoy = date('Y-m-d');// FECHA ACTUAL

//CON POST TOMAMOS UN VALOR DEL 0 AL 4 PARA VER QUE ACCION HACER (Insertar = 0, Actualizar Info = 1, Actualizar Est = 2, Borrar = 3, Permisos = 4)
$Accion = $conn->real_escape_string($_POST['accion']);
if ($Accion != 0) {
	//ARCHIVO QUE CONDICIONA QUE TENGAMOS ACCESO A ESTE ARCHIVO SOLO SI HAY SESSION INICIADA Y NOS PREMITE TIMAR LA INFORMACION DE ESTA
	include('is_logged.php');
	$id_user = $_SESSION['user_id'];// ID DEL USUARIO LOGEADO
}
//UN SWITCH EL CUAL DECIDIRA QUE ACCION REALIZA DEL CRUD (Insertar = 0, Actualizar Info = 1, Actualizar Est = 2, Borrar = 3, Permisos = 4)
switch ($Accion) {
    case 0:  ///////////////           IMPORTANTE               ///////////////
        // $Accion es igual a 0 realiza:

    	//CON POST RECIBIMOS TODAS LAS VARIABLES DEL FORMULARIO POR EL SCRIPT "form_usuario.php" QUE NESECITAMOS PARA INSERTAR
    	$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/",";","?", "php", "echo","$","{","}","=");
		$caracteres_buenos = array("", "", "", "", "", "", "", "", "","","", "","","", "","","");

		// Eliminamos cualquier tipo de código HTML o JavaScript
		$valorNombreAsociado = $conn->real_escape_string($_POST["valorNombreAsociado"]);
		$valorCantidad = $conn->real_escape_string($_POST["valorCantidad"]);
		$valorTelefono = $conn->real_escape_string($_POST["valorTelefono"]);
		$tipo = $conn->real_escape_string($_POST["tipo"]);

		//ELIMINAR CODIGO PHP
		$valorNombreAsociado = str_replace($caracteres_malos, $caracteres_buenos, $valorNombreAsociado);
		$valorCantidad = str_replace($caracteres_malos, $caracteres_buenos, $valorCantidad);
		$valorTelefono = str_replace($caracteres_malos, $caracteres_buenos, $valorTelefono);
		if ($tipo == 'Efectivo') {
			$sql = "INSERT INTO `asociados` (nombre, telefono, cantidad, tipo, estatus, fecha)
		            VALUES ('$valorNombreAsociado','$valorTelefono','$valorCantidad', '$tipo', 1,'$Fecha_hoy')";
		    // Si el usuario fue añadido con éxito
		    if (mysqli_query($conn,$sql)) {
		         ?>
                <script>
                    M.toast({html:"Asociado agregado exitosamente", classes: "rounded"});
                    setTimeout("location.href='detalles_proceso.php?tipo=Efectivo'", 800);
                </script>
                <?php
		    } else {
		        echo '<script>M.toast({html:"Hubo un error, intentelo mas tarde.", classes: "rounded"})</script>';
		    }
		}else if ($tipo == 'Especie') {
			// code...
		}
        break;
    case 1:///////////////           IMPORTANTE               ///////////////
        // $Accion es igual a 1 realiza:

		$user_id = $conn->real_escape_string($_POST['valorId']);//VALOR DEL USUARIO A EDITAR POR POST "perfil_user.php"

		//REALIZAMOS LA CONSULTA PARA SACAR LA INFORMACION DEL USUARIO Y ASIGNAMOS EL ARRAY A UNA VARIABLE $area
		$area = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE user_id=$id_user"));

		if($area['area'] == "Administrador" OR $user_id == $id_user){
			//CON POST RECIBIMOS TODAS LAS VARIABLES DEL FORMULARIO POR EL SCRIPT "perfil_user.php" QUE NESECITAMOS PARA ACTUALIZAR
			$Nombres = $conn->real_escape_string($_POST['valorNombres']);
			$Apellidos = $conn->real_escape_string($_POST['valorApellidos']);
			$Usuario = $conn->real_escape_string($_POST['valorUsuario']);
			$Email = $conn->real_escape_string($_POST['valorEmail']);
			//CREAMOS LA SENTENCIA SQL PARA HACER LA ACTUALIZACION DE LA INFORMACION DEL USUARIO Y LA GUARDAMOS EN UNA VARIABLE
			$sql = "UPDATE users SET firstname='$Nombres', lastname='$Apellidos', user_name='$Usuario', user_email = '$Email' WHERE user_id='$user_id'";
			//VERIFICAMOS QUE SE EJECUTE LA SENTENCIA EN MYSQL 
			if(mysqli_query($conn, $sql)){
				echo '<script>M.toast({html:"El perfil se actualizó correctamente.", classes: "rounded"})</script>';
				echo '<script>recargar_usuarios()</script>';// REDIRECCIONAMOS (FUNCION ESTA EN ARCHIVO modals.php)
			}else{
				echo '<script>M.toast({html:"Ha ocurrido un error.", classes: "rounded"})</script>';	
			}
		}else{
		  echo "<script >M.toast({html: 'Sólo un administrador o el mismo usuario puede editar un perfil.', classes: 'rounded'});</script>";
		}
        break;
    case 2:///////////////           IMPORTANTE               ///////////////
        // $Accion es igual a 2 realiza:

    	//CON POST RECIBIMOS TODAS LAS VARIABLES DEL FORMULARIO POR EL SCRIPT "usuarios.php" QUE NESECITAMOS PARA ACTUALIZAR
    	$valorId = $conn->real_escape_string($_POST["valorId"]);
		$valorEstatus = $conn->real_escape_string($_POST["valorEstatus"]);

		//CREAMOS LA SENTENCIA SQL PARA ACTUALIZAR
		$sql= "UPDATE users SET estatus = '$valorEstatus' WHERE user_id = '$valorId'";
		//VERIIFCAMOS QUE SE HAYA REALIZADO LA SENTENCIA EN LA BASE DE DATOS
		if(mysqli_query($conn, $sql)){
		    echo '<script>M.toast({html:"Usuario actualizado..", classes: "rounded"})</script>';
			echo '<script>recargar_usuarios()</script>';// REDIRECCIONAMOS (FUNCION ESTA EN ARCHIVO modals.php)
		}else{
		    echo '<script>M.toast({html:"Hubo un error, intentelo mas tarde.", classes: "rounded"})</script>';
		}
        break;
    case 3:///////////////           IMPORTANTE               ///////////////
        // $Accion es igual a 3 realiza:

    	//CON POST RECIBIMOS LA VARIABLE DEL BOTON POR EL SCRIPT DE "usuarios.php" QUE NESECITAMOS PARA BORRAR
    	$valorId = $conn->real_escape_string($_POST["valorId"]);

		#VERIFICAMOS QUE SE BORRE CORRECTAMENTE EL USUARIO DE `users`
		if(mysqli_query($conn, "DELETE FROM users WHERE user_id=$valorId")){
			#SI ES ELIMINADO MANDAR MSJ CON ALERTA
		    echo '<script>M.toast({html:"Usuario eliminado.", classes: "rounded"})</script>';
			echo '<script>recargar_usuarios()</script>';// REDIRECCIONAMOS (FUNCION ESTA EN ARCHIVO modals.php)
		}else{
			#SI NO ES BORRADO MANDAR UN MSJ CON ALERTA
		    echo '<script>M.toast({html:"Hubo un error, intentelo mas tarde.", classes: "rounded"})</script>';
		}
        break;
	case 4:///////////////           IMPORTANTE               ///////////////
    	//$Accion es gual a 4 relizar:

    	//CON POST RECIBIMOS TODAS LAS VARIABLES DEL FORMULARIO POR EL SCRIPT "permisos.php" QUE NESECITAMOS PARA CAMBIARLOS
    	$id = $conn->real_escape_string($_POST["id"]);
    	$Banco = $conn->real_escape_string($_POST["Banco"]);
    	$Credito = $conn->real_escape_string($_POST["Credito"]);
    	$BorrarPagos = $conn->real_escape_string($_POST["BorrarPagos"]);
    	$BorrarClientes = $conn->real_escape_string($_POST["BorrarClientes"]);
    	$BorrarVentas = $conn->real_escape_string($_POST["BorrarVentas"]);
		$BorrarAlmacenes = $conn->real_escape_string($_POST["BorrarAlmacenes"]);
    	$Ventas = $conn->real_escape_string($_POST["Ventas"]);
    	$Compras = $conn->real_escape_string($_POST["Compras"]);
    	$Articulos = $conn->real_escape_string($_POST["Articulos"]);
		$Almacen = $conn->real_escape_string($_POST["valorAlmacen"]);
    	//CREAMOS LA SENTENCIA SQL PARA HACER LA ACTUALIZACION DE LOS PERMISOS DEL USUARIO Y LA GUARDAMOS EN UNA VARIABLE
		$sql = "UPDATE users SET banco='$Banco', credito='$Credito', b_pagos='$BorrarPagos', b_clientes = '$BorrarClientes', b_ventas = '$BorrarVentas', ventas = '$Ventas', compras = '$Compras',  b_articulos = '$Articulos', b_almacenes = '$BorrarAlmacenes', almacen = '$Almacen' WHERE user_id='$id'";
		//VERIFICAMOS QUE SE EJECUTE LA SENTENCIA EN MYSQL 
		if(mysqli_query($conn, $sql)){
			echo '<script>M.toast({html:"Permisos actualizados correctamente.", classes: "rounded"})</script>';
			echo '<script>recargar_usuarios()</script>';// REDIRECCIONAMOS (FUNCION ESTA EN ARCHIVO modals.php)
		}else{
			echo '<script>M.toast({html:"Ha ocurrido un error.", classes: "rounded"})</script>';	
		}
    	break;
    case 5:///////////////           IMPORTANTE               ///////////////
    	// $Accion es igual a 5 realiza:

    	//CON POST RECIBIMOS TODAS LAS VARIABLES DEL FORMULARIO POR EL SCRIPT "perfil_user.php" QUE NESECITAMOS PARA ACTUALIZAR
    	$id_user = $conn->real_escape_string($_POST["valorId"]);
		$Password_new = $conn->real_escape_string($_POST["valorContra"]);
		$Password_old = $conn->real_escape_string($_POST["valorContraAnterior"]);

		$user=mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM users WHERE user_id = '$id_user'"));

		if (password_verify($Password_old, $user['user_password_hash'])) {
			$Password_new_hash = password_hash($Password_new, PASSWORD_DEFAULT);
			//CREAMOS LA SENTENCIA SQL PARA ACTUALIZAR
			$sql= "UPDATE users SET user_password_hash = '$Password_new_hash' WHERE user_id = '$id_user'";
			//VERIIFCAMOS QUE SE HAYA REALIZADO LA SENTENCIA EN LA BASE DE DATOS
			if(mysqli_query($conn, $sql)){
			    echo '<script>M.toast({html:"Usuario actualizado (Contraseña)..", classes: "rounded"})</script>';
				echo '<script>cerrar_sesion()</script>';// REDIRECCIONAMOS (FUNCION ESTA EN ARCHIVO modals.php)
			}else{
			    echo '<script>M.toast({html:"Hubo un error, intentelo mas tarde.", classes: "rounded"})</script>';
			}
		}else{
			#SI LAS CONTRASEÑA ANTERIOR NO ES IGUAL MANDA UN MSJ CON ALERTA
		    echo '<script>M.toast({html:"La contraseña anterior no coincide.", classes: "rounded"})</script>';
		}
    	break;
}// FIN switch
mysqli_close($conn);