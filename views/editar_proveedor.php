<?php
//VERIFICAMOS QUE SI NOS ENVIE POR POST EL ID DEL PROVEEDOR
if (isset($_POST['id']) == false) {
  ?>
  <script>    
    M.toast({html: "Regresando a proveedores.", classes: "rounded"});
    setTimeout("location.href='list_proveedores.php'", 800);
  </script>
  <?php
}else{
?>
  <html>
  <head>
  	<title>SIC | Editar Proveedores</title>
    <?php 
    //INCLUIMOS EL ARCHIVO QUE CONTIENE LA BARRA DE NAVEGACION TAMBIEN TIENE (scripts, conexion, is_logged, modals)
    include('fredyNav.php');
    $id = $_POST['id'];// POR EL METODO POST RECIBIMOS EL ID DEL CLIENTE
    //REALIZAMOS LA CONSULTA PARA SACAR LA INFORMACION DEL CLIENTE Y ASIGNAMOS EL ARRAY A UNA VARIABLE $datos
    $datos = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `proveedores` WHERE id=$id"));
    ?>
    <script>
      //FUNCION QUE AL USAR VALIDA LA VARIABLE QUE LLEVE UN FORMATO DE CORREO 
      function validar_email( email )   {
        var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email) ? true : false;
      };

      //FUNCION QUE HACE LA ACTUALIZACION DEL CLIENTE (SE ACTIVA AL PRECIONAR UN BOTON)
      function update_proveedor(id) {

        //PRIMERO VAMOS Y BUSCAMOS EN ESTE MISMO ARCHIVO LA INFORMCION REQUERIDA Y LA ASIGNAMOS A UNA VARIABLE
        var textoNombre = $("input#nombre").val();//ej:LA VARIABLE "textoNombre" GUARDAREMOS LA INFORMACION QUE ESTE EN EL INPUT QUE TENGA EL id = "nombre"
        var textoDireccion = $("input#direccion").val();// ej: TRAE LE INFORMACION DEL INPUT FILA  (id="direccion")
        var textoEmail = $("input#email").val();

        // CREAMOS CONDICIONES QUE SI SE CUMPLEN MANDARA MENSAJES DE ALERTA EN FORMA DE TOAST
        //SI SE CUMPLEN LOS IF QUIERE DECIR QUE NO PASA LOS REQUISITOS MINIMOS DE LLENADO...
        if (textoNombre == "") {
            M.toast({html: 'El campo Nombre se encuentra vacío.', classes: 'rounded'});
        }else if(textoDireccion.length == ""){
            M.toast({html: 'El campo Dirección se encuentra vacío.', classes: 'rounded'});
        }else if(textoEmail == ""){
            M.toast({html:"Por favor ingrese un Correo.", classes: "rounded"});
        }else if (!validar_email(textoEmail)) {
            M.toast({html:"Por favor ingrese un Correo correcto.", classes: "rounded"});
        }else{
            //SI LOS IF NO SE CUMPLEN QUIERE DECIR QUE LA INFORMACION CUENTA CON TODO LO REQUERIDO
            //MEDIANTE EL METODO POST ENVIAMOS UN ARRAY CON LA INFORMACION AL ARCHIVO EN LA DIRECCION "../php/control_proveedores.php"
            $.post("../php/control_proveedores.php", {
            //Cada valor se separa por una ,
                accion: 2,
                id: id,
                valorNombre: textoNombre,
                valorDireccion: textoDireccion,
                valorEmail: textoEmail,
            }, function(mensaje) {
                //SE CREA UNA VARIABLE LA CUAL TRAERA EN TEXTO HTML LOS RESULTADOS QUE ARROJE EL ARCHIVO AL CUAL SE LE ENVIO LA INFORMACION "control_proveedores.php"
                $("#resultado_update").html(mensaje);
            }); 
        }//FIN else CONDICIONES
      };//FIN function 
    </script>
  </head>
  <main>
  <body>
    <!-- DENTRO DE ESTE DIV VA TODO EL CONTENIDO Y HACE QUE SE VEA AL CENTRO DE LA PANTALLA.-->
    <div class="container"><br><br>
      <!--    //////    TITULO    ///////   -->
      <div class="row" >
        <h3 class="hide-on-med-and-down">Editar Proveedor N°<?php echo $id; ?></h3>
        <h5 class="hide-on-large-only">Editar Proveedor N°<?php echo $id; ?></h5>
      </div>
      <div class="row" >
       <!-- CREAMOS UN DIV EL CUAL TENGA id = "resultado_update"  PARA QUE EN ESTA PARTE NOS MUESTRE LOS RESULTADOS EN TEXTO HTML DEL SCRIPT EN FUNCION  -->
       <div id="resultado_update"></div>
       <div class="row">
        <!-- FORMULARIO EL CUAL SE MUETRA EN PANTALLA .-->
        <form class="row col s12">
          <!-- DIV QUE SEPARA A DOBLE COLUMNA PARTE IZQ.-->
          <div class="col s12 m6 l6">
              <br>
              <div class="input-field">
              <i class="material-icons prefix">people</i>
              <input id="nombre" type="text" class="validate" data-length="50" required value="<?php echo $datos['nombre']; ?>">
              <label for="nombre">Nombre:</label>
            </div>      
            <div class="input-field">
              <i class="material-icons prefix">location_city</i>
              <input id="direccion" type="text" class="validate" data-length="80" required value="<?php echo $datos['direccion']; ?>">
              <label for="direccion">Dirección:</label>
            </div>         
          </div>
          <!-- DIV DOBLE COLUMNA EN ESCRITORIO PARTE DERECHA -->
          <div class="col s12 m6 l6">
              <br>
            <div class="input-field">
              <i class="material-icons prefix">email</i>
              <input id="email" type="text" class="validate" data-length="45" required value="<?php echo $datos['correo']; ?>">
              <label for="email">E-mail:</label>
            </div> 
          </div>
        </form>
        <!-- BOTON QUE MANDA LLAMAR EL SCRIPT PARA QUE EL SCRIPT HAGA LO QUE LA FUNCION CONTENGA -->
        <a onclick="update_proveedor(<?php echo $id; ?>);" class="waves-effect waves-light btn pink right"><i class="material-icons right">save</i>Guardar</a>
      </div> 
    </div><br>
  </body>
  </main>
  </html>
<?php
}// FIN else POST
?>