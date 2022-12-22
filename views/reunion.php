<html>
    <head>
        <title>Pro-puesta2023 | Reunion </title>
        <?php 
            //INCLUIMOS EL ARCHIVO QUE CONTIENE LA BARRA DE NAVEGACION TAMBIEN TIENE (scripts, conexion, modals)
            include('fredyNav.php');
            //VARIABLE VACIA
            $S3=" ";
        ?>
        <script>
            //FUNCION QUE HACE LA INSERCION DEL ASOCIADO
            function insert_beneficiario() {

                //PRIMERO VAMOS Y BUSCAMOS EN ESTE MISMO ARCHIVO LA INFORMCION REQUERIDA Y LA ASIGNAMOS A UNA VARIABLE
                var textoNombre = $("input#nombre").val();
                var textoTelefono = $("input#telefono").val();
                var textoCorreo = $("input#correo").val();
                var textoEmpresa = $("input#empresa").val();
                // CREAMOS CONDICIONES QUE SI SE CUMPLEN MANDARA MENSAJES DE ALERTA EN FORMA DE TOAST
                //SI SE CUMPLEN LOS IF QUIERE DECIR QUE NO PASA LOS REQUISITOS MINIMOS DE LLENADO...
                    //SI LOS IF NO SE CUMPLEN QUIERE DECIR QUE LA INFORMACION CUENTA CON TODO LO REQUERIDO
                    //MEDIANTE EL METODO POST ENVIAMOS UN ARRAY CON LA INFORMACION AL ARCHIVO EN LA DIRECCION "../php/control_asociados.php"
                    $.post("../php/control_beneficiarios.php", {
                        //Cada valor se separa por una ,
                        accion: 2,
                        valorNombre: textoNombre,
                        valorTelefono: textoTelefono,
                        valorCorreo: textoCorreo,
                        valorEmpresa: textoEmpresa,
                    }, function(mensaje) {
                        //SE CREA UNA VARIABLE LA CUAL TRAERA EN TEXTO HTML LOS RESULTADOS QUE ARROJE EL ARCHIVO AL CUAL SE LE ENVIO LA INFORMACION "control_asociados.php"
                        $("#resultado_insert").html(mensaje);
                    }); 
            };//FIN function 
            //FUINCION QUE AL SELECCIONAR UN Cliente MUESTRA SU INFORMACION
            function showContent() {
                var textoProveedor = $("select#proveedor").val();
                
                //MEDIANTE EL METODO POST ENVIAMOS UN ARRAY CON LA INFORMACION AL ARCHIVO EN LA DIRECCION "../php/control_beneficiarios.php"
                $.post("../php/control_beneficiarios.php", {
                  //Cada valor se separa por una ,
                    accion: 1,
                    proveedor: textoProveedor,
                  }, function(mensaje) {
                    //SE CREA UNA VARIABLE LA CUAL TRAERA EN TEXTO HTML LOS RESULTADOS QUE ARROJE EL ARCHIVO AL CUAL SE LE ENVIO LA INFORMACION "control_beneficiarios.php"
                    $("#resultado_info").html(mensaje);
                });  
            };
        </script>
    </head>
    <main>
        <body>
            <!-- DENTRO DE ESTE DIV VA TODO EL CONTENIDO Y HACE QUE SE VEA AL CENTRO DE LA PANTALLA.-->
            <div class="container"><br><br>
            <!--    //////    TITULO    ///////   -->
            <div class="row" >
                <h3 class="hide-on-med-and-down">Reunion</h3>
                <h5 class="hide-on-large-only">Reunion</h5>
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
                            <input id="nombre" type="text" class="validate" data-length="50" required>
                            <label for="nombre">*Nombre :</label>
                        </div>      
                        <div class="input-field">
                            <i class="material-icons prefix">phone</i>
                            <input id="telefono" type="text" class="validate" data-length="30" required>
                            <label for="telefono">*Teléfono :</label>
                        </div> 
                    </div>
                    <!-- DIV DOBLE COLUMNA EN ESCRITORIO PARTE DERECHA -->
                    <div class="col s12 m6 l6">
                        <br>
                        <div class="input-field">
                            <i class="material-icons prefix">attach_money</i>
                            <input id="correo" type="text" class="validate" data-length="11" required>
                            <label for="correo">*Correo:</label>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">attach_money</i>
                            <input id="empresa" type="text" class="validate" data-length="11" required>
                            <label for="empresa">*Empresa:</label>
                        </div>
                    </div>
                </form>
                <!-- BOTON QUE MANDA LLAMAR EL SCRIPT PARA QUE EL SCRIPT HAGA LO QUE LA FUNCION CONTENGA -->
                <a onclick="insert_beneficiario();" class="waves-effect waves-light btn green right"><i class="material-icons right">send</i>REGISTRAR</a>
            </div> 
            </div><br>
        </body>
    </main>
</html>