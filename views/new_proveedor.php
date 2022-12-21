<html>
    <head>
        <title>Pro-puesta2023 | Nuevo Proveedor</title>
        <?php 
            //INCLUIMOS EL ARCHIVO QUE CONTIENE LA BARRA DE NAVEGACION TAMBIEN TIENE (scripts, conexion, modals)
            include('fredyNav.php');
        ?>
        <script>
            //FUNCION QUE AL USAR VALIDA LA VARIABLE QUE LLEVE UN FORMATO DE CORREO 
              function validar_email( email )   {
                var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email) ? true : false;
              };
            //FUNCION QUE HACE LA INSERCION DEL ASOCIADO
            function insert_proveedor() {

                //PRIMERO VAMOS Y BUSCAMOS EN ESTE MISMO ARCHIVO LA INFORMCION REQUERIDA Y LA ASIGNAMOS A UNA VARIABLE
                var textoNombrePro = $("input#nombre_pro").val();
                var textoCorreoPro = $("input#correo_pro").val();
                var textoDireccionPro = $("input#direccion_pro").val();
                // CREAMOS CONDICIONES QUE SI SE CUMPLEN MANDARA MENSAJES DE ALERTA EN FORMA DE TOAST
                //SI SE CUMPLEN LOS IF QUIERE DECIR QUE NO PASA LOS REQUISITOS MINIMOS DE LLENADO...
                if (textoNombrePro == "") {
                    M.toast({html: 'El campo Nombre se encuentra vacío.', classes: 'rounded'});
                }else if (textoDireccionPro == "") {
                    M.toast({html: 'El campo Dirección se encuentra vacío.', classes: 'rounded'});
                }else if (textoCorreoPro == "") {
                    M.toast({html: 'El campo Correo se encuentra vacío.', classes: 'rounded'});
                }else if (!validar_email(textoCorreoPro)) {
                    M.toast({html:"Por favor ingrese un Email correcto.", classes: "rounded"});
                }else {
                    //SI LOS IF NO SE CUMPLEN QUIERE DECIR QUE LA INFORMACION CUENTA CON TODO LO REQUERIDO
                    //MEDIANTE EL METODO POST ENVIAMOS UN ARRAY CON LA INFORMACION AL ARCHIVO EN LA DIRECCION "../php/control_proveedores.php"
                    $.post("../php/control_proveedores.php", {
                        //Cada valor se separa por una ,
                        accion: 0,
                        valorNombrePro: textoNombrePro,
                        valorDireccionPro: textoDireccionPro,
                        valorCorreoPro: textoCorreoPro,
                    }, function(mensaje) {
                        //SE CREA UNA VARIABLE LA CUAL TRAERA EN TEXTO HTML LOS RESULTADOS QUE ARROJE EL ARCHIVO AL CUAL SE LE ENVIO LA INFORMACION "control_proveedores.php"
                        $("#resultado_insert").html(mensaje);
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
                <h3 class="hide-on-med-and-down">Registrar Proveedor</h3>
                <h5 class="hide-on-large-only">Registrar Proveedor</h5>
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
                            <input id="nombre_pro" type="text" class="validate" data-length="50" required>
                            <label for="nombre_pro">*Nombre del proveedor:</label>
                        </div>      
                        <div class="input-field">
                            <i class="material-icons prefix">phone</i>
                            <input id="correo_pro" type="text" class="validate" data-length="30" required>
                            <label for="correo_pro">*Correo del proveedor:</label>
                        </div> 
                    </div>
                    <!-- DIV DOBLE COLUMNA EN ESCRITORIO PARTE DERECHA -->
                    <div class="col s12 m6 l6">
                        <br>
                        <div class="input-field">
                            <i class="material-icons prefix">location_city</i>
                            <input id="direccion_pro" type="text" class="validate" data-length="60" required>
                            <label for="direccion_pro">*Dirección del proveedor:</label>
                        </div>   
                    </div>
                </form>
                <!-- BOTON QUE MANDA LLAMAR EL SCRIPT PARA QUE EL SCRIPT HAGA LO QUE LA FUNCION CONTENGA -->
                <a onclick="insert_proveedor();" class="waves-effect waves-light btn green right"><i class="material-icons right">send</i>REGISTRAR</a>
            </div> 
            </div><br>
        </body>
    </main>
</html>