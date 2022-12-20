<html>
  <head>
    <title>Pro-puesta2023 | Nuevo Asociado</title>
    <?php 
    //INCLUIMOS EL ARCHIVO QUE CONTIENE LA BARRA DE NAVEGACION TAMBIEN TIENE (scripts, conexion, modals)
    include('nav.php');
    ?>
    <script>
      //FUNCION QUE HACE LA INSERCION DEL ASOCIADO
      function insert_asociado() {

        //PRIMERO VAMOS Y BUSCAMOS EN ESTE MISMO ARCHIVO LA INFORMCION REQUERIDA Y LA ASIGNAMOS A UNA VARIABLE
        var textoNombreAsociado = $("input#nombre_asociado").val();
        var textoCantidad = $("input#cantidad_asociado").val();
        var textoTelefono = $("input#telefono_asociado").val();
        Entra = false;
        if (document.getElementById('esepecie').checked==true) {
          var textoNombreEmp = $("input#nombre_emp").val();
          var textoDireccion = $("input#direccion_emp").val();
          var textoCorreo = $("input#correo_emp").val();
          tipo = 'Especie';
          Entra = true;
          if(textoNombreEmp == ""){
            texto = 'El campo Nombre Empresa se encuentra vacío';
          }else if(textoDireccion == ""){
            texto = 'El campo Dirección se encuentra vacío';
          }else if(textoCorreo == ""){
            texto = 'El campo Correo se encuentra vacío';
          }else {
            Entra = false;
          }
        }else{
          tipo = 'Efectivo'; textoNombreEmp = ''; textoCorreo = ''; textoDireccion = '';
        }

        // CREAMOS CONDICIONES QUE SI SE CUMPLEN MANDARA MENSAJES DE ALERTA EN FORMA DE TOAST
        //SI SE CUMPLEN LOS IF QUIERE DECIR QUE NO PASA LOS REQUISITOS MINIMOS DE LLENADO...
        if (textoNombreAsociado == "") {
          M.toast({html: 'El campo Nombre se encuentra vacío.', classes: 'rounded'});
        }else if (textoTelefono == "") {
          M.toast({html: 'El campo Telefono se encuentra vacío.', classes: 'rounded'});
        }else if (textoCantidad == "") {
          M.toast({html: 'El campo Cantidad se encuentra vacío.', classes: 'rounded'});
        }else if (document.getElementById('esepecie').checked==false && document.getElementById('efectivo').checked==false) { 
          M.toast({html: 'Seleccione una casilla para el tipo de donativo', classes: 'rounded'});
        }else if(Entra){
            M.toast({html: texto, classes: 'rounded'});
        }else {
          //SI LOS IF NO SE CUMPLEN QUIERE DECIR QUE LA INFORMACION CUENTA CON TODO LO REQUERIDO
          //MEDIANTE EL METODO POST ENVIAMOS UN ARRAY CON LA INFORMACION AL ARCHIVO EN LA DIRECCION "../php/control_asociados.php"
          $.post("../php/control_asociados.php", {
            //Cada valor se separa por una ,
              accion: 0,
              valorNombreAsociado: textoNombreAsociado,
              valorCantidad: textoCantidad,
              valorTelefono: textoTelefono,
              tipo: tipo,
              valorNombreEmp: textoNombreEmp,
              valorDireccion: textoDireccion,
              valorCorreo: textoCorreo,
            }, function(mensaje) {
                //SE CREA UNA VARIABLE LA CUAL TRAERA EN TEXTO HTML LOS RESULTADOS QUE ARROJE EL ARCHIVO AL CUAL SE LE ENVIO LA INFORMACION "control_asociados.php"
                $("#resultado_insert").html(mensaje);
            }); 
        }//FIN else CONDICIONES
      };//FIN function 
      function showContent() {
        element = document.getElementById("content");
        element2 = document.getElementById("content2");
        element3 = document.getElementById("content3");
        element4 = document.getElementById("content4");
        if (document.getElementById('esepecie').checked==true) {
            element.style.display='block';
            element2.style.display='block';
            element3.style.display='block';
            element4.style.display='block';
        }  else {
            element.style.display='none';
            element2.style.display='none';
            element3.style.display='none';
            element4.style.display='none';
        }    
      };
    </script>
  </head>
  <main>
  <body>
    <!-- DENTRO DE ESTE DIV VA TODO EL CONTENIDO Y HACE QUE SE VEA AL CENTRO DE LA PANTALLA.-->
    <div class="container"><br><br>
      <!--    //////    TITULO    ///////   -->
      <div class="row" >
        <h3 class="hide-on-med-and-down">Registrar Asociado</h3>
        <h5 class="hide-on-large-only">Registrar Asociado</h5>
      </div>
      <div class="row" >
       <!-- CREAMOS UN DIV EL CUAL TENGA id = "resultado_insert"  PARA QUE EN ESTA PARTE NOS MUESTRE LOS RESULTADOS EN TEXTO HTML DEL SCRIPT EN FUNCION  -->
       <div id="resultado_insert"></div>
       <div class="row">
        <!-- FORMULARIO EL CUAL SE MUETRA EN PANTALLA .-->
        <form class="row col s12">
          <!-- DIV QUE SEPARA A DOBLE COLUMNA PARTE IZQ.-->
          <div class="col s12 m6 l6">
            <br>
            <div class="input-field">
              <i class="material-icons prefix">people</i>
              <input id="nombre_asociado" type="text" class="validate" data-length="50" required>
              <label for="nombre_asociado">*Nombre de la persona o empresa:</label>
            </div>      
            <div class="input-field">
              <i class="material-icons prefix">phone</i>
              <input id="telefono_asociado" type="text" class="validate" data-length="30" required>
              <label for="telefono_asociado">*Telefono:</label>
            </div> 
            <br><h5 id="content" style="display: none;">Al elegir en esepecie se registrara tu empersa o negocio como proveedor</h5>   

            <div class="input-field" id="content2" style="display: none;">
              <i class="material-icons prefix">people</i>
              <input id="nombre_emp" type="text" class="validate" data-length="50" required>
              <label for="nombre_emp">*Nombre del negocio:</label>
            </div> 
            <div class="input-field" id="content3" style="display: none;">
              <i class="material-icons prefix">people</i>
              <input id="direccion_emp" type="text" class="validate" data-length="50" required>
              <label for="direccion_emp">*Direccion:</label>
            </div>  
          </div>
          <!-- DIV DOBLE COLUMNA EN ESCRITORIO PARTE DERECHA -->
          <div class="col s12 m6 l6">
            <br>
            <div class="input-field">
              <i class="material-icons prefix">monetization_on</i>
              <input id="cantidad_asociado" type="number" class="validate" data-length="30" required>
              <label for="cantidad_asociado">*Cantidad:</label>
            </div>  
            <div class="input-field">
              <p class="col s6">
                <label>
                  <input type="checkbox" id="efectivo" />
                  <span>*En Efectivo</span>
                </label>
              </p>
              <p class="col s6">
                <label>
                  <input type="checkbox" id="esepecie" onchange="javascript:showContent()"/>
                  <span>*En Especie</span>
                </label>
              </p><br><br><br><br><br><br>
            </div>            
            <div class="input-field" id="content4" style="display: none;"><br>
              <i class="material-icons prefix">people</i>
              <input id="correo_emp" type="text" class="validate" data-length="50" required>
              <label for="correo_emp">*Correo:</label>
            </div>  
          </div>
        </form>
        <!-- BOTON QUE MANDA LLAMAR EL SCRIPT PARA QUE EL SCRIPT HAGA LO QUE LA FUNCION CONTENGA -->
        <a onclick="insert_asociado();" class="waves-effect waves-light btn green right"><i class="material-icons right">send</i>ENVIAR</a>
      </div> 
    </div><br>
  </body>
  </main>
</html>