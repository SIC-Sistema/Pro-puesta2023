
<!--Script Buscar clientes-->
<script>
function recargar_asociados() {
    setTimeout("location.href='../views/asociados.php'", 800);
  
  }
</script>
<!--Termina Script Buscar clientes-->

<!-- Modal Buscar clientes -->
  <div id="buscar_clientes" class="modal modal-fixed-footer">
    <div class="modal-content">
      <nav>
        <div class="nav-wrapper">
          <form>
            <div class="input-field pink lighten-4">
              <input id="buscar_cliente" type="search" placeholder="Buscar Cliente" maxlength="30" value="" autocomplete="off" onKeyUp="PulsarTecla();" autofocus="true" required>
              <label class="label-icon" for="search"><i class="material-icons">search</i></label>
              <i class="material-icons">close</i>
            </div>
          </form>
        </div>
      </nav>
      <p><div id="resultado_clientes"></div></p>
    </div>
    <div class="modal-footer container">
      <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Cerrar<i class="material-icons right">close</i></a>
    </div>
  </div>
<!--.....Termina Modal Buscar clientes-->

