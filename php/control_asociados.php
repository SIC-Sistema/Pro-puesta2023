<?php 
// Si estamos usando una versión de PHP superior entonces usamos la API para encriptar la contrasela con el archivo: password_api_compatibility_library.php
include_once("password_compatibility_library.php");
//ARCHIVO QUE CONTIENE LA VARIABLE CON LA CONEXION A LA BASE DE DATOS
include('../php/conexion.php');

//DEFINIMOS LA ZONA  HORARIA
date_default_timezone_set('America/Mexico_City');
$Fecha_hoy = date('Y-m-d');// FECHA ACTUAL

//CON POST TOMAMOS UN VALOR DEL 0 AL 4 PARA VER QUE ACCION HACER (Insertar = 0, consulta1 = 1, consulta2 = 2, cambio entrego = 3)
$Accion = $conn->real_escape_string($_POST['accion']);
if ($Accion != 0) {
	//ARCHIVO QUE CONDICIONA QUE TENGAMOS ACCESO A ESTE ARCHIVO SOLO SI HAY SESSION INICIADA Y NOS PREMITE TIMAR LA INFORMACION DE ESTA
	include('is_logged.php');
	$id_user = $_SESSION['user_id'];// ID DEL USUARIO LOGEADO
}
//UN SWITCH EL CUAL DECIDIRA QUE ACCION REALIZA DEL CRUD (Insertar = 0, consulta1 = 1, consulta2 = 2, cambio entrego = 3)
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
			$sql = "INSERT INTO `asociados` (nombre, telefono, cantidad, tipo, estatus, fecha)
		            VALUES ('$valorNombreAsociado','$valorTelefono','$valorCantidad', '$tipo', 2,'$Fecha_hoy')";
		    // Si el usuario fue añadido con éxito
		    if (mysqli_query($conn,$sql)) {
		    	//creamos el proveedor con saldo - 
		    	$cuenta = -1*$valorCantidad;
		    	$valorNombreEmp = $conn->real_escape_string($_POST["valorNombreEmp"]);
				$valorDireccion = $conn->real_escape_string($_POST["valorDireccion"]);
				$valorCorreo = $conn->real_escape_string($_POST["valorCorreo"]);
				$tipo = $conn->real_escape_string($_POST["tipo"]);

				//ELIMINAR CODIGO PHP
				$valorNombreEmp = str_replace($caracteres_malos, $caracteres_buenos, $valorNombreEmp);
				$valorDireccion = str_replace($caracteres_malos, $caracteres_buenos, $valorDireccion);
				$valorCorreo = str_replace($caracteres_malos, $caracteres_buenos, $valorCorreo);
		    	$sql_p = "INSERT INTO `proveedores` (nombre, direccion, correo, cuenta,  fecha)
		            VALUES ('$valorNombreEmp','$valorDireccion','$valorCorreo', '$cuenta', '$Fecha_hoy')";
		        mysqli_query($conn,$sql_p);
		        $ultimo =  mysqli_fetch_array(mysqli_query($conn, "SELECT MAX(id) AS id FROM `proveedores` WHERE correo = '$valorCorreo' AND fecha = '$Fecha_hoy'"));            
        		$id = $ultimo['id'];
        		$sql_vales = "UPDATE `recaudaciones` SET vales = vales+$valorCantidad WHERE id_recaudacion = 1";
		        mysqli_query($conn,$sql_vales);
		         ?>
                <script>
                    M.toast({html:"Asociado y proveedor agregado exitosamente", classes: "rounded"});
                    setTimeout("location.href='home.php'", 800);
                    var a = document.createElement("a");
	                    a.target = "_blank";
	                    a.href = "../php/comprobante_especie.php?id="+<?php echo $id; ?>;
	                    a.click();
                </script>
                <?php
		    } else {
		        echo '<script>M.toast({html:"Hubo un error, intentelo mas tarde.", classes: "rounded"})</script>';
		    }
		}
        break;
   	case 1:  ///////////////           IMPORTANTE               ///////////////
        // $Accion es igual a 1 realiza:

        //CON POST RECIBIMOS UN TEXTO DEL BUSCADOR VACIO O NO de "asociados.php"
        $Texto = $conn->real_escape_string($_POST['texto']);
        //VERIFICAMOS SI CONTIENE ALGO DE TEXTO LA VARIABLE
		if ($Texto != "") {
			//MOSTRARA LOS asociados QUE SE ESTAN BUSCANDO Y GUARDAMOS LA CONSULTA SQL EN UNA VARIABLE $sql......
			$sql = "SELECT * FROM `asociados` WHERE estatus = 1 AND (nombre LIKE '%$Texto%' OR id = '$Texto' OR tipo LIKE '$Texto%' OR telefono LIKE '$Texto%') ORDER BY id";	
		}else{//ESTA CONSULTA SE HARA SIEMPRE QUE NO ALLA NADA EN EL BUSCADOR Y GUARDAMOS LA CONSULTA SQL EN UNA VARIABLE $sql...
			$sql = "SELECT * FROM `asociados` WHERE estatus = 1 ORDER BY id";
		}//FIN else $Texto VACIO O NO

        // REALIZAMOS LA CONSULTA A LA BASE DE DATOS MYSQL Y GUARDAMOS EN FORMARTO ARRAY EN UNA VARIABLE $consulta
		$consulta = mysqli_query($conn, $sql);		
		$contenido = '';//CREAMOS UNA VARIABLE VACIA PARA IR LLENANDO CON LA INFORMACION EN FORMATO

		//VERIFICAMOS QUE LA VARIABLE SI CONTENGA INFORMACION
		if (mysqli_num_rows($consulta) == 0) {
			echo '<script>M.toast({html:"No se encontraron asociados.", classes: "rounded"})</script>';
        } else {
            //SI NO ESTA EN == 0 SI TIENE INFORMACION
            //RECORREMOS UNO A UNO LOS asociados CON EL WHILE
            while($asociado = mysqli_fetch_array($consulta)) {
				//Output
				$estatus = ($asociado['estatus'] == 1)? '<b class = "red-text">Sin Entregar</b>':'<b class = "green-text">Entregado</b>';
                $contenido .= '			
		          <tr>
		            <td>'.$asociado['id'].'</td>
		            <td>'.$asociado['nombre'].'</td>
		            <td>'.$asociado['telefono'].'</td>
		            <td>En '.$asociado['tipo'].'</td>
		            <td>'.$asociado['fecha'].'</td>
		            <td>$'.sprintf('%.2f', $asociado['cantidad']).'</td>
		            <td>'.$estatus.'</td>
		            <td><a onclick="entrego('.$asociado['id'].')" class="btn btn-floating green waves-effect waves-light"><i class="material-icons">arrow_forward</i></a></td>
		          </tr>';

			}//FIN while
        }//FIN else

        echo $contenido;// MOSTRAMOS LA INFORMACION HTML

        break;
    case 2:///////////////           IMPORTANTE               ///////////////
        // $Accion es igual a 2 realiza:

    	//CON POST RECIBIMOS UN TEXTO DEL BUSCADOR VACIO O NO de "asociados.php"
        $Texto = $conn->real_escape_string($_POST['texto']);
        //VERIFICAMOS SI CONTIENE ALGO DE TEXTO LA VARIABLE
		if ($Texto != "") {
			//MOSTRARA LOS asociados QUE SE ESTAN BUSCANDO Y GUARDAMOS LA CONSULTA SQL EN UNA VARIABLE $sql......
			$sql = "SELECT * FROM `asociados` WHERE estatus = 2 AND (nombre LIKE '%$Texto%' OR id = '$Texto' OR tipo LIKE '$Texto%' OR telefono LIKE '$Texto%') ORDER BY id";	
		}else{//ESTA CONSULTA SE HARA SIEMPRE QUE NO ALLA NADA EN EL BUSCADOR Y GUARDAMOS LA CONSULTA SQL EN UNA VARIABLE $sql...
			$sql = "SELECT * FROM `asociados` WHERE estatus = 2 ORDER BY id";
		}//FIN else $Texto VACIO O NO

        // REALIZAMOS LA CONSULTA A LA BASE DE DATOS MYSQL Y GUARDAMOS EN FORMARTO ARRAY EN UNA VARIABLE $consulta
		$consulta = mysqli_query($conn, $sql);		
		$contenido = '';//CREAMOS UNA VARIABLE VACIA PARA IR LLENANDO CON LA INFORMACION EN FORMATO

		//VERIFICAMOS QUE LA VARIABLE SI CONTENGA INFORMACION
		if (mysqli_num_rows($consulta) == 0) {
			echo '<script>M.toast({html:"No se encontraron asociados.", classes: "rounded"})</script>';
        } else {
            //SI NO ESTA EN == 0 SI TIENE INFORMACION
            //RECORREMOS UNO A UNO LOS asociados CON EL WHILE
            while($asociado = mysqli_fetch_array($consulta)) {
				//Output
				$estatus = ($asociado['estatus'] == 1)? '<b class = "red-text">Sin Entregar</b>':'<b class = "green-text">Entregado</b>';
                $contenido .= '			
		          <tr>
		            <td>'.$asociado['id'].'</td>
		            <td>'.$asociado['nombre'].'</td>
		            <td>'.$asociado['telefono'].'</td>
		            <td>En '.$asociado['tipo'].'</td>
		            <td>'.$asociado['fecha'].'</td>
		            <td>$'.sprintf('%.2f', $asociado['cantidad']).'</td>
		            <td>'.$estatus.'</td>
		          </tr>';

			}//FIN while
        }//FIN else

        echo $contenido;// MOSTRAMOS LA INFORMACION HTML
        break;
    case 3:///////////////           IMPORTANTE               ///////////////
        // $Accion es igual a 3 realiza:

    	//CON POST RECIBIMOS LA VARIABLE DEL BOTON POR EL SCRIPT DE "usuarios.php" QUE NESECITAMOS PARA BORRAR
    	$id = $conn->real_escape_string($_POST["id"]);
  		$asociado = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `asociados` WHERE id = $id"));

		if(mysqli_query($conn, "UPDATE `asociados` SET estatus = 2 WHERE id = $id")){
			#CREAR TICKET
			#SUMAR A LA CANTIDAD
			$cantidad = $asociado['cantidad'];
			$sql_efectivo = "UPDATE `recaudaciones` SET efectivo = efectivo+$cantidad WHERE id_recaudacion = 1";
		    mysqli_query($conn,$sql_efectivo);
		    echo '<script>M.toast({html:"Estatus Cambiado.", classes: "rounded"})</script>';
			echo '<script>recargar_asociados()</script>';// REDIRECCIONAMOS (FUNCION ESTA EN ARCHIVO modals.php)
		}else{
			#SI NO ES BORRADO MANDAR UN MSJ CON ALERTA
		    echo '<script>M.toast({html:"Hubo un error, intentelo mas tarde.", classes: "rounded"})</script>';
		}
        break;
}// FIN switch
mysqli_close($conn);