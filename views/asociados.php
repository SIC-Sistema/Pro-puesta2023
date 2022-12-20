<html>
<head>
	<title>Pro-puesta2023 | Asociados</title>
  <?php 
  include('fredyNav.php');
  include('../php/admin.php');
  date_default_timezone_set('America/Mexico_City');
  $Fecha_hoy = date('Y-m-d');?>
  <script>
    //FUNCION QUE BORRA TODOS LOS ARTICULOS DE TMP (SE ACTIVA AL INICIAR EL BOTON BORRAR)
    function entrego(id){
      var answer = confirm("El socio N°"+id+" ya a entregado su aportacion (Efectivo)? \n\nSe generara su ticket y se incrementara la suma del total");
      if (answer) {
        //MEDIANTE EL METODO POST ENVIAMOS UN ARRAY CON LA INFORMACION AL ARCHIVO EN LA DIRECCION "../php/control_asociados.php"
        $.post("../php/control_asociados.php", {
        //Cada valor se separa por una ,
          id: id,
          accion: 3,
        }, function(mensaje){
            //SE CREA UNA VARIABLE LA CUAL TRAERA EN TEXTO HTML LOS RESULTADOS QUE ARROJE EL ARCHIVO AL CUAL SE LE ENVIO LA INFORMACION "control_asociados.php"
            $("#entregoEfe").html(mensaje);
        });//FIN post
      }//FIN IF
    };//FIN function
    
    //FUNCION QUE HACE LA BUSQUEDA DE ALMACENES (SE ACTIVA AL INICIAR EL ARCHIVO O AL ECRIBIR ALGO EN EL BUSCADOR)
    function buscarAsociadosSi(){
      //PRIMERO VAMOS Y BUSCAMOS EN ESTE MISMO ARCHIVO EL TEXTO REQUERIDO Y LO ASIGNAMOS A UNA VARIABLE
      var texto = $("input#busqueda1").val();
      //MEDIANTE EL METODO POST ENVIAMOS UN ARRAY CON LA INFORMACION AL ARCHIVO EN LA DIRECCION "../php/controlventas.php"
      $.post("../php/control_asociados.php", {
        //Cada valor se separa por una ,
          texto: texto,
          accion: 1,
        }, function(mensaje){
            //SE CREA UNA VARIABLE LA CUAL TRAERA EN TEXTO HTML LOS RESULTADOS QUE ARROJE EL ARCHIVO AL CUAL SE LE ENVIO LA INFORMACION "control_asociados.php"
            $("#AsociadosNo").html(mensaje);
      });//FIN post
    }//FIN function}

    //FUNCION QUE HACE LA BUSQUEDA DE ALMACENES (SE ACTIVA AL INICIAR EL ARCHIVO O AL ECRIBIR ALGO EN EL BUSCADOR)
    function buscarAsociadosNo(){
      //PRIMERO VAMOS Y BUSCAMOS EN ESTE MISMO ARCHIVO EL TEXTO REQUERIDO Y LO ASIGNAMOS A UNA VARIABLE
      var texto = $("input#busqueda2").val();
      //MEDIANTE EL METODO POST ENVIAMOS UN ARRAY CON LA INFORMACION AL ARCHIVO EN LA DIRECCION "../php/controlventas.php"
      $.post("../php/control_asociados.php", {
        //Cada valor se separa por una ,
          texto: texto,
          accion: 2,
        }, function(mensaje){
            //SE CREA UNA VARIABLE LA CUAL TRAERA EN TEXTO HTML LOS RESULTADOS QUE ARROJE EL ARCHIVO AL CUAL SE LE ENVIO LA INFORMACION "control_asociados.php"
            $("#AsociadosSi").html(mensaje);
      });//FIN post
    }//FIN function
  </script>
</head>
<main>
<body onload="buscarAsociadosSi(); buscarAsociadosNo();">
  <div class="container">
    <!-- CREAMOS UN DIV EL CUAL TENGA id = "entregoEfe"  PARA QUE EN ESTA PARTE NOS MUESTRE LOS RESULTADOS EN TEXTO HTML DEL SCRIPT EN FUNCION  -->
    <div id="entregoEfe"></div>
    <!-- CREAMOS UN DIV EL CUAL TENGA id = "modal"  PARA QUE EN ESTA PARTE NOS MUESTRE LOS RESULTADOS EN TEXTO HTML DEL SCRIPT EN FUNCION  -->
    <div id="modal"></div>
    <div class="row" ><br>
      <h3 class="hide-on-med-and-down">Asociados</h3>
      <h5 class="hide-on-large-only">Asociados</h5>
    </div>
    <div class="row">
    <!-- ----------------------------  TABs o MENU  ---------------------------------------->
      <div class="col s12">
        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s6"><a class="active black-text" href="#test-swipe-1">APORTACION SIN ENTREGAR</a></li>
          <li class="tab col s6"><a class="black-text" href="#test-swipe-2">APORTACIONES ENTREGADAS</a></li>
        </ul>
      </div>
      <!-- ----------------------------  FORMULARIO 1 Tabs  ---------------------------------------->
      <div  id="test-swipe-1" class="col s12"><br><br>
        <!--    //////    INPUT DE LA BUSQUEDA    ///////   -->   
        <div class="input-field col s12 m6 l6 right">
          <i class="material-icons prefix">search</i>
          <input id="busqueda1" name="busqueda1" type="text" class="validate" onkeyup="buscarAsociadosSi();">
          <label for="busqueda1">Buscar: (N°, Nombre, Tipo, Telefono)</label>
        </div>
        <div class="row"><br>
            <table class="bordered centered highlight">
              <thead>
                <tr>
                  <th>N°</th>
                  <th>Nombre</th>
                  <th>Telefono</th>
                  <th>Tipo</th>
                  <th>Fecha</th>
                  <th>Aportación</th> 
                  <th>Estatus</th>
                  <th>Entrega</th>
                </tr>
              </thead>
              <tbody id="AsociadosNo">
              </tbody>
            </table>
        </div>
      </div>
      <!-- ----------------------------  FORMULARIO 2 Tabs  ---------------------------------------->
      <div  id="test-swipe-2" class="col s12"><br><br>
        <!--    //////    INPUT DE LA BUSQUEDA    ///////   -->   
        <div class="input-field col s12 m6 l6 right">
          <i class="material-icons prefix">search</i>
          <input id="busqueda2" name="busqueda2" type="text" class="validate" onkeyup="buscarAsociadosNo();">
          <label for="busqueda2">Buscar: (N°, Nombre, Tipo, Telefono)</label>
        </div>
        <div class="row"><br>
            <table class="bordered centered highlight">
              <thead>
                <tr>
                  <th>N°</th>
                  <th>Nombre</th>
                  <th>Telefono</th>
                  <th>Tipo</th>
                  <th>Fecha</th>
                  <th>Aportación</th> 
                  <th>Estatus</th>
                </tr>
              </thead>
              <tbody id="AsociadosSi">
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</body>
</main>
</html>