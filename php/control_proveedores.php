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

//CON POST TOMAMOS UN VALOR DEL 0 AL 4 PARA VER QUE ACCION HACER (Insertar = 0, consulta = 1, Actualizar = 2, Borrar = 3, Permisos = 4)
$Accion = $conn->real_escape_string($_POST['accion']);

//UN SWITCH EL CUAL DECIDIRA QUE ACCION REALIZA DEL CRUD (Insertar = 0, consulta = 1, Actualizar = 2, Borrar = 3, Permisos = 4)
switch ($Accion) {
    case 0:  ///////////////           IMPORTANTE               ///////////////
        // $Accion es igual a 0 realiza: 

		// Eliminamos cualquier tipo de código HTML o JavaScript
		$valorNombrePro = $conn->real_escape_string($_POST["valorNombrePro"]);
		$valorDireccionPro = $conn->real_escape_string($_POST["valorDireccionPro"]);
		$valorCorreoPro = $conn->real_escape_string($_POST["valorCorreoPro"]);

		if (mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `proveedores` WHERE nombre = '$valorNombrePro' AND correo = '$valorCorreoPro'"))>0) {
			echo '<script>M.toast({html:"Ya existe un proveedor con la misma información.", classes: "rounded"})</script>';
		}else{
			$sql = "INSERT INTO `proveedores` (nombre, direccion, correo, cuenta, fecha) VALUES ('$valorNombrePro','$valorDireccionPro','$valorCorreoPro', 0, '$Fecha_hoy')";
			// Si el usuario fue añadido con éxito
			if (mysqli_query($conn,$sql)) {
			    ?>
	            <script>
	                M.toast({html:"Proveedor agregado exitosamente", classes: "rounded"});
	                setTimeout("location.href='../views/list_proveedores.php'", 800);
	            </script>
	            <?php
			} else {
			    echo '<script>M.toast({html:"Hubo un error, intentelo mas tarde.", classes: "rounded"})</script>';
			}
		}
        break;
    case 1:///////////////           IMPORTANTE               ///////////////
        // $Accion es igual a 1 realiza:

        //CON POST RECIBIMOS UN TEXTO DEL BUSCADOR VACIO O NO de "list_proveedores.php"
        $Texto = $conn->real_escape_string($_POST['texto']);
        //VERIFICAMOS SI CONTIENE ALGO DE TEXTO LA VARIABLE
		if ($Texto != "") {
			//MOSTRARA LOS proveedores QUE SE ESTAN BUSCANDO Y GUARDAMOS LA CONSULTA SQL EN UNA VARIABLE $sql......
			$sql = "SELECT * FROM `proveedores` WHERE (nombre LIKE '%$Texto%' OR id = '$Texto' OR correo LIKE '%$Texto%') ORDER BY id";	
		}else{//ESTA CONSULTA SE HARA SIEMPRE QUE NO ALLA NADA EN EL BUSCADOR Y GUARDAMOS LA CONSULTA SQL EN UNA VARIABLE $sql...
			$sql = "SELECT * FROM `proveedores` ORDER BY id";
		}//FIN else $Texto VACIO O NO

        // REALIZAMOS LA CONSULTA A LA BASE DE DATOS MYSQL Y GUARDAMOS EN FORMARTO ARRAY EN UNA VARIABLE $consulta
		$consulta = mysqli_query($conn, $sql);		
		$contenido = '';//CREAMOS UNA VARIABLE VACIA PARA IR LLENANDO CON LA INFORMACION EN FORMATO

		//VERIFICAMOS QUE LA VARIABLE SI CONTENGA INFORMACION
		if (mysqli_num_rows($consulta) == 0) {
			echo '<script>M.toast({html:"No se encontraron proveedores.", classes: "rounded"})</script>';
        } else {
            //SI NO ESTA EN == 0 SI TIENE INFORMACION
            //RECORREMOS UNO A UNO LOS provedores CON EL WHILE
            while($proveedor = mysqli_fetch_array($consulta)) {
				//Output
				$cuenta = ($proveedor['cuenta'] > 0)? '<b class = "red-text">$'.sprintf('%.2f', $proveedor['cuenta']).'</b>':'<b class = "green-text">$'.sprintf('%.2f', $proveedor['cuenta']).'</b>';
                $contenido .= '			
		          <tr>
		            <td>'.$proveedor['id'].'</td>
		            <td>'.$proveedor['nombre'].'</td>
		            <td>'.$proveedor['direccion'].'</td>
		            <td>'.$proveedor['correo'].'</td>
		            <td>$'.sprintf('%.2f', $proveedor['salidas']).'</td>
		            <td>'.$cuenta.'</td>
		            <td>'.$proveedor['fecha'].'</td>
		            <td><br><form method="post" action="../views/editar_proveedor.php"><input id="id" name="id" type="hidden" value="'.$proveedor['id'].'"><button class="btn-floating waves-effect waves-light green"><i class="material-icons">edit</i></button></form></td>
		            <td><a onclick="borrar_proveedor('.$proveedor['id'].')" class="btn btn-floating red  darken-3 waves-effect waves-light"><i class="material-icons">delete</i></a></td>
		          </tr>';

			}//FIN while
        }//FIN else

        echo $contenido;// MOSTRAMOS LA INFORMACION HTML
        break;
    case 2:///////////////           IMPORTANTE               ///////////////
        // $Accion es igual a 2 realiza:
    	//CON POST RECIBIMOS TODAS LAS VARIABLES DEL FORMULARIO POR EL SCRIPT "usuarios.php" QUE NESECITAMOS PARA ACTUALIZAR
    	$id = $conn->real_escape_string($_POST["id"]);
		$valorNombre = $conn->real_escape_string($_POST["valorNombre"]);
		$valorDireccion = $conn->real_escape_string($_POST["valorDireccion"]);
		$valorEmail = $conn->real_escape_string($_POST["valorEmail"]);

		//CREAMOS LA SENTENCIA SQL PARA ACTUALIZAR
		$sql= "UPDATE proveedores SET nombre = '$valorNombre', direccion = '$valorDireccion', correo = '$valorEmail' WHERE id = '$id'";
		//VERIIFCAMOS QUE SE HAYA REALIZADO LA SENTENCIA EN LA BASE DE DATOS
		if(mysqli_query($conn, $sql)){
			?>
	        <script>
	            M.toast({html:"Proveedor actualizado", classes: "rounded"});
	            setTimeout("location.href='../views/list_proveedores.php'", 800);
	        </script>
	        <?php
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