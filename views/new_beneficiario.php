<html>
    <head>
        <title> SIC | Nuevo Beneficiario </title>
        <?php 
            //INCLUIMOS EL ARCHIVO QUE CONTIENE LA BARRA DE NAVEGACION TAMBIEN TIENE (scripts, conexion, modals)
            include('nav.php');
        ?>
        <script>
            //FUNCION QUE HACE LA INSERCION DEL ASOCIADO
            function insert_beneficiario() {

                //PRIMERO VAMOS Y BUSCAMOS EN ESTE MISMO ARCHIVO LA INFORMCION REQUERIDA Y LA ASIGNAMOS A UNA VARIABLE
                var textoNombreBeneficiario = $("input#nombre_beneficiario").val();
                var textoTelefono = $("input#telefono_beneficiario").val();
                var textoDireccion = $("input#direccion_beneficiario").val();
                var textoAsociado = $("select#asociado").val();
                // CREAMOS CONDICIONES QUE SI SE CUMPLEN MANDARA MENSAJES DE ALERTA EN FORMA DE TOAST
                //SI SE CUMPLEN LOS IF QUIERE DECIR QUE NO PASA LOS REQUISITOS MINIMOS DE LLENADO...
                if (textoNombreBeneficiario == "") {
                M.toast({html: 'El campo Nombre se encuentra vacío.', classes: 'rounded'});
                }else if (textoTelefono == "") {
                M.toast({html: 'El campo Telefono se encuentra vacío.', classes: 'rounded'});
                }else if (textoDireccion == "") {
                M.toast({html: 'El campo Dirección se encuentra vacío.', classes: 'rounded'});
                }else if (textoDireccion == "") {
                M.toast({html: 'El campo Dirección se encuentra vacío.', classes: 'rounded'});
                }else {
                    //SI LOS IF NO SE CUMPLEN QUIERE DECIR QUE LA INFORMACION CUENTA CON TODO LO REQUERIDO
                    //MEDIANTE EL METODO POST ENVIAMOS UN ARRAY CON LA INFORMACION AL ARCHIVO EN LA DIRECCION "../php/control_asociados.php"
                    $.post("../php/control_beneficiarios.php", {
                        //Cada valor se separa por una ,
                        accion: 0,
                        valorNombreBeneficiario: textoNombreBeneficiario,
                        valorTelefono: textoTelefono,
                        valorDireccion: textoDireccion,
                        valorAsociado: textoAsociado,
                    }, function(mensaje) {
                        //SE CREA UNA VARIABLE LA CUAL TRAERA EN TEXTO HTML LOS RESULTADOS QUE ARROJE EL ARCHIVO AL CUAL SE LE ENVIO LA INFORMACION "control_asociados.php"
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
                <h3 class="hide-on-med-and-down">Registrar Beneficiario</h3>
                <h5 class="hide-on-large-only">Registrar Beneficiario</h5>
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
                            <input id="nombre_beneficiario" type="text" class="validate" data-length="50" required>
                            <label for="nombre_beneficiario">*Nombre de la persona beneficiada:</label>
                        </div>      
                        <div class="input-field">
                            <i class="material-icons prefix">phone</i>
                            <input id="telefono_beneficiario" type="text" class="validate" data-length="30" required>
                            <label for="telefono_beneficiario">*Teléfono del beneficiario:</label>
                        </div> 
                    </div>
                    <!-- DIV DOBLE COLUMNA EN ESCRITORIO PARTE DERECHA -->
                    <div class="col s12 m6 l6">
                        <br>
                        <div class="input-field">
                            <i class="material-icons prefix">location_city</i>
                            <input id="direccion_beneficiario" type="text" class="validate" data-length="60" required>
                            <label for="direccion_beneficiario">*Dirección del beneficiario:</label>
                        </div>
                        <!-- CAJA DE SELECCION DE ASOCIADOS -->
                        <div class="input-field">
                            <i class="material-icons prefix">person_pin</i>
                            <select id="asociado" name="asociado" class="validate">
                                <!--OPTION PARA QUE LA SELECCION QUEDE POR DEFECTO VACIA-->
                                <option value="0" select>Seleccione un asociado</option>
                                <?php 
                                // REALIZAMOS LA CONSULTA A LA BASE DE DATOS MYSQL Y GUARDAMOS EN FORMARTO ARRAY EN UNA VARIABLE $consulta
                                $consulta = mysqli_query($conn,"SELECT * FROM asociados");
                                //VERIFICAMOS QUE LA VARIABLE SI CONTENGA INFORMACION
                                if (mysqli_num_rows($consulta) == 0) {
                                    echo '<script>M.toast({html:"No se encontraron asociados.", classes: "rounded"})</script>';
                                }else{
                                    //RECORREMOS UNO A UNO LOS ARTICULOS CON EL WHILE
                                    while($asociados = mysqli_fetch_array($consulta)) {
                                    //Output
                                        ?>                      
                                        <option value="<?php echo $asociados['id'];?>"><?php echo $asociados['nombre'];// MOSTRAMOS LA INFORMACION HTML?></option>-->
                                        <?php
                                    }//FIN while
                                }//FIN else
                                ?>
                            </select>
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