<html>
<head>
	<title>Pro-puesta2023 | Proveedores</title>
  <?php 
  include('fredyNav.php');
  date_default_timezone_set('America/Mexico_City');
  $Fecha_hoy = date('Y-m-d');?>
  <script>    
    //FUNCION QUE HACE LA BUSQUEDA DE ALMACENES (SE ACTIVA AL INICIAR EL ARCHIVO O AL ECRIBIR ALGO EN EL BUSCADOR)
    function buscarProvecdor(){
      //PRIMERO VAMOS Y BUSCAMOS EN ESTE MISMO ARCHIVO EL TEXTO REQUERIDO Y LO ASIGNAMOS A UNA VARIABLE
      var texto = $("input#busqueda1").val();
      //MEDIANTE EL METODO POST ENVIAMOS UN ARRAY CON LA INFORMACION AL ARCHIVO EN LA DIRECCION "../php/control_proveedores.php"
      $.post("../php/control_proveedores.php", {
        //Cada valor se separa por una ,
          texto: texto,
          accion: 1,
        }, function(mensaje){
            //SE CREA UNA VARIABLE LA CUAL TRAERA EN TEXTO HTML LOS RESULTADOS QUE ARROJE EL ARCHIVO AL CUAL SE LE ENVIO LA INFORMACION "control_proveedores.php"
            $("#ProvedorRes").html(mensaje);
      });//FIN post
    }//FIN function}
    //FUNCION QUE MANDA LA INFORMACION PARA CAMBIAR DE ESTATUS AL USUARIO ACTIVO-DESACTIVADO (SE ACCIONA CON BOTON)
    function cambiar(estatus, id){
      //MEDIANTE EL METODO POST ENVIAMOS UN ARRAY CON LA INFORMACION AL ARCHIVO EN LA DIRECCION "../php/control_proveedores.php"
      $.post("../php/control_proveedores.php", { 
          accion: 3,
          valorId: id,
          valorEstatus: estatus,
        }, function(mensaje) {
          //SE CREA UNA VARIABLE LA CUAL TRAERA EN TEXTO HTML LOS RESULTADOS QUE ARROJE EL ARCHIVO AL CUAL SE LE ENVIO LA INFORMACION "control_proveedores.php"
          $("#cancelar").html(mensaje);
        });  //FIN post
    };//FIN function    
  </script>
</head>
<main>
<body onload="buscarProvecdor();">
  <div class="container">
    <!-- CREAMOS UN DIV EL CUAL TENGA id = "cancelar"  PARA QUE EN ESTA PARTE NOS MUESTRE LOS RESULTADOS EN TEXTO HTML DEL SCRIPT EN FUNCION  -->
    <div id="cancelar"></div>
    <!-- CREAMOS UN DIV EL CUAL TENGA id = "modal"  PARA QUE EN ESTA PARTE NOS MUESTRE LOS RESULTADOS EN TEXTO HTML DEL SCRIPT EN FUNCION  -->
    <div id="modal"></div>
    <div class="row" ><br>
      <h3 class="hide-on-med-and-down">Proveedores</h3>
      <h5 class="hide-on-large-only">Proveedores</h5>
    </div>
    <div class="row">
        <!--    //////    INPUT DE LA BUSQUEDA    ///////   -->   
        <div class="input-field col s12 m6 l6 right">
          <i class="material-icons prefix">search</i>
          <input id="busqueda1" name="busqueda1" type="text" class="validate" onkeyup="buscarProvecdor();">
          <label for="busqueda1">Buscar: (N° , Nombre, Correo)</label>
        </div>
        <div class="row"><br>
            <table class="bordered centered highlight">
              <thead>
                <tr>
                  <th>N°</th>
                  <th>Nombre</th>
                  <th>Direccion</th>
                  <th>Correo</th>            
                  <th>Salidas</th>
                  <th>Cuenta</th>
                  <th>Fecha</th>
                  <th>Estatus</th>
                  <th>Cambiar</th>
                  <th>Editar</th>
                </tr>
              </thead>
              <tbody id="ProvedorRes">
              </tbody>
            </table>
        </div>
    </div>
  </div>
</body>
</main>
</html>