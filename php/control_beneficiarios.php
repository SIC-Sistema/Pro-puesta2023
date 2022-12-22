<?php 
// Si estamos usando una versión de PHP superior entonces usamos la API para encriptar la contrasela con el archivo: password_api_compatibility_library.php
include_once("password_compatibility_library.php");
//ARCHIVO QUE CONTIENE LA VARIABLE CON LA CONEXION A LA BASE DE DATOS
include('../php/conexion.php');
include('is_logged.php');
//DEFINIMOS LA ZONA  HORARIA
date_default_timezone_set('America/Mexico_City');
$Fecha_hoy = date('Y-m-d');// FECHA ACTUAL
$id_user = $_SESSION['user_id'];// ID DEL USUARIO LOGEADO

//CON POST TOMAMOS UN VALOR DEL 0 AL 4 PARA VER QUE ACCION HACER (Insertar = 0, buscar Info = 1)
$Accion = $conn->real_escape_string($_POST['accion']);

//UN SWITCH EL CUAL DECIDIRA QUE ACCION REALIZA DEL CRUD (Insertar = 0, buscar Info = 1)
switch ($Accion) {
    case 0:  ///////////////           IMPORTANTE               ///////////////
        // $Accion es igual a 0 realiza:

    	//CON POST RECIBIMOS TODAS LAS VARIABLES DEL FORMULARIO POR EL SCRIPT "form_usuario.php" QUE NESECITAMOS PARA INSERTAR
    	$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/",";","?", "php", "echo","$","{","}","=");
		$caracteres_buenos = array("", "", "", "", "", "", "", "", "","","", "","","", "","","");

		// Eliminamos cualquier tipo de código HTML o JavaScript
		$valorNombreBeneficiario = $conn->real_escape_string($_POST["valorNombreBeneficiario"]);
		$valorTelefono = $conn->real_escape_string($_POST["valorTelefono"]);
		$valorCantidad = $conn->real_escape_string($_POST["valorCantidad"]);
		$valorProveedor = $conn->real_escape_string($_POST["valorProveedor"]);

		//ELIMINAR CODIGO PHP
		//$valorNombreBeneficiario = str_replace($caracteres_malos, $caracteres_buenos, $valorNombreBeneficiario);
		//$valorTelefono = str_replace($caracteres_malos, $caracteres_buenos, $valorTelefono);
		//$valorDireccion = str_replace($caracteres_malos, $caracteres_buenos, $valorDireccion);
        //$valorAsociado = str_replace($caracteres_malos, $caracteres_buenos, $valorAsociado);

		$sql = "INSERT INTO `beneficiarios` (nombre, telefono, cantidad, proveedor, registro, fecha_registro) VALUES ('$valorNombreBeneficiario','$valorTelefono',$valorCantidad, $valorProveedor, $id_user,'$Fecha_hoy')";
		// Si el usuario fue añadido con éxito
		if (mysqli_query($conn,$sql)) {
		    ?>
            <script>
                M.toast({html:"Beneficiario agregado exitosamente", classes: "rounded"});
                setTimeout("location.href='../views/new_beneficiario.php'", 800);
            </script>
            <?php
		} else {
		    echo '<script>M.toast({html:"Hubo un error, intentelo mas tarde.", classes: "rounded"})</script>';
		}
        break;
    case 1:///////////////           IMPORTANTE               ///////////////
        // $Accion es igual a 1 realiza:
//CON POST RECIBIMOS EL ID DEL PROVEEDOR DEL FORMULARIO POR EL SCRIPT "add_compra.php" QUE NESECITAMOS PARA BUSCAR
    	$id = $conn->real_escape_string($_POST['proveedor']);    
        $contenido = '';//CREAMOS UNA VARIABLE VACIA PARA IR LLENANDO CON LA INFORMACION EN FORMATO
        //VERIFICAMOS SI CONTIENE ALGO DE TEXTO LA VARIABLE
        if ($id != 0) {
            //HACEMOS LA CONSULTA DEL cliente Y MOSTRAMOS LA INFOR EN FORMATO HTML
            $proveedor = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `proveedores` WHERE id=$id"));
            $cuenta=($proveedor['cuenta'] <= 0)? '<b class = "green-text">$'.sprintf('%.2f',$proveedor['cuenta']).'</b>':'<b class = "red-text">$'.sprintf('%.2f',$proveedor['cuenta']).'</b>';
            $contenido .= '<h6 right><b>Cuenta: </b>'.$cuenta.'<b>   Salidas: $'.sprintf('%.2f',$proveedor['salidas']).'</b></h6>';
        }else{
            echo '<h6><b>Cuenta: $0.00   Salidas: $0.00</b></h6>';
        }
        echo $contenido;// IMPRIMIMOS EL CONTENDIO QUE PUEDE IR VACIO SI ES $id = 0
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